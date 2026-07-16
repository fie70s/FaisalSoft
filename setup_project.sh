#!/bin/bash

echo "🚀 البدء في إنشاء مشروع FaisalSoft وتجهيزه لـ GitHub..."

# 1. إنشاء المجلدات الأساسية للنظام
mkdir -p app/Models
mkdir -p app/Services/MikroTik/Hotspot
mkdir -p database/migrations

# 2. كتابة ملف .gitignore لمنع رفع الملفات الحساسة
cat << 'EOF' > .gitignore
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.phpunit.result.cache
docker-compose.override.yml
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log
/.idea
/.vscode
EOF

# 3. إنشاء ملف ApiService.php
cat << 'EOF' > app/Services/MikroTik/ApiService.php
<?php

namespace App\Services\MikroTik;

use Exception;

class ApiService
{
    private $socket;
    private $connected = false;

    public function connect(string $ip, string $username, string $password, int $port = 8728): bool
    {
        $this->socket = @fsockopen($ip, $port, $errno, $errstr, 5);
        if (!$this->socket) {
            throw new Exception("تعذر الاتصال بالجهاز $ip على المنفذ $port. الخطأ: $errstr");
        }

        socket_set_timeout($this->socket, 5);
        $this->connected = true;

        if (!$this->login($username, $password)) {
            $this->disconnect();
            throw new Exception("فشل تسجيل الدخول: اسم المستخدم أو كلمة المرور غير صحيحة.");
        }

        return true;
    }

    private function login(string $username, string $password): bool
    {
        $response = $this->comm("/login", [
            "=name=" . $username,
            "=password=" . $password,
        ]);

        if (isset($response['!trap'])) {
            return false;
        }

        return true;
    }

    public function comm(string $command, array $params = []): array
    {
        if (!$this->connected) {
            throw new Exception("الـ API غير متصل بجهاز الميكروتك حالياً.");
        }

        $this->writeWord($command);
        foreach ($params as $param) {
            $this->writeWord($param);
        }
        $this->writeWord(""); 

        $response = [];
        $current = [];

        while (true) {
            $word = $this->readWord();
            if ($word == "!done") {
                if (!empty($current)) {
                    $response[] = $current;
                }
                break;
            } elseif ($word == "!re") {
                if (!empty($current)) {
                    $response[] = $current;
                    $current = [];
                }
            } elseif ($word == "!trap") {
                $current['!trap'] = true;
            } elseif (preg_match('/^=([^=]+)=(.*)$/s', $word, $matches)) {
                $current[$matches[1]] = $matches[2];
            }
        }

        return $response;
    }

    private function writeWord(string $word): void
    {
        $length = strlen($word);
        if ($length < 0x80) {
            fwrite($this->socket, chr($length));
        } elseif ($length < 0x4000) {
            $length |= 0x8000;
            fwrite($this->socket, chr(($length >> 8) & 0xFF) . chr($length & 0xFF));
        } elseif ($length < 0x200000) {
            $length |= 0xC00000;
            fwrite($this->socket, chr(($length >> 16) & 0xFF) . chr(($length >> 8) & 0xFF) . chr($length & 0xFF));
        }
        fwrite($this->socket, $word);
    }

    private function readWord(): string
    {
        $byte = ord(fread($this->socket, 1));
        $length = 0;
        if (($byte & 0x80) == 0x00) {
            $length = $byte;
        } elseif (($byte & 0xC0) == 0x80) {
            $length = (($byte & 0x3F) << 8) + ord(fread($this->socket, 1));
        } elseif (($byte & 0xE0) == 0xC0) {
            $length = (($byte & 0x1F) << 16) + (ord(fread($this->socket, 1)) << 8) + ord(fread($this->socket, 1));
        }
        
        return $length > 0 ? fread($this->socket, $length) : "";
    }

    public function disconnect(): void
    {
        if ($this->socket) {
            @fclose($this->socket);
        }
        $this->connected = false;
    }
}
EOF

# 4. إنشاء ملف DeviceService.php
cat << 'EOF' > app/Services/MikroTik/DeviceService.php
<?php

namespace App\Services\MikroTik;

use App\Models\MikroTikDevice;
use Exception;

class DeviceService
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function checkConnection(MikroTikDevice $device): bool
    {
        try {
            $this->apiService->connect(
                $device->ip_address,
                $device->username,
                decrypt($device->password),
                $device->port ?? 8728
            );
            
            $systemInfo = $this->apiService->comm("/system/resource/print");
            $this->apiService->disconnect();

            if (!empty($systemInfo)) {
                $device->update(['status' => 'online', 'last_checked_at' => now()]);
                return true;
            }
        } catch (Exception $e) {
            $device->update(['status' => 'offline', 'last_checked_at' => now()]);
        }

        return false;
    }

    public function registerDevice(array $data): MikroTikDevice
    {
        $data['password'] = encrypt($data['password']);
        $data['status'] = 'offline';

        $device = MikroTikDevice::create($data);
        $this->checkConnection($device);

        return $device;
    }
}
EOF

# 5. إنشاء ملف HotspotUserSyncService.php
cat << 'EOF' > app/Services/MikroTik/Hotspot/HotspotUserSyncService.php
<?php

namespace App\Services\MikroTik\Hotspot;

use App\Models\HotspotUser;
use App\Models\MikroTikDevice;
use App\Services\MikroTik\ApiService;
use Exception;

class HotspotUserSyncService
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function syncUserToDevice(HotspotUser $user, MikroTikDevice $device): bool
    {
        try {
            $this->apiService->connect(
                $device->ip_address,
                $device->username,
                decrypt($device->password),
                $device->port ?? 8728
            );

            $existing = $this->apiService->comm("/ip/hotspot/user/print", [
                "?name" => $user->username
            ]);

            if (empty($existing)) {
                $this->apiService->comm("/ip/hotspot/user/add", [
                    "=name=" . $user->username,
                    "=password=" . $user->password,
                    "=profile=" . ($user->profile ?? "default"),
                    "=limit-uptime=" . ($user->limit_uptime ?? "00:00:00"),
                    "=comment=" . "FaisalSoft - Sync " . now()->format('Y-m-d')
                ]);
            } else {
                $userId = $existing[0]['.id'];
                $this->apiService->comm("/ip/hotspot/user/set", [
                    "=.id=" . $userId,
                    "=password=" . $user->password,
                    "=profile=" . ($user->profile ?? "default"),
                    "=limit-uptime=" . ($user->limit_uptime ?? "00:00:00")
                ]);
            }

            $this->apiService->disconnect();
            
            $user->update(['is_synced' => true, 'synced_at' => now()]);
            return true;

        } catch (Exception $e) {
            logger("فشلت مزامنة المستخدم {$user->username}: " . $e->getMessage());
            return false;
        }
    }
}
EOF

# 6. إنشاء ملفات قواعد البيانات (Migrations)
cat << 'EOF' > database/migrations/2026_01_01_000001_create_mikrotik_devices_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mikrotik_devices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('ip_address');
            $table->string('username');
            $table->text('password');
            $table->integer('port')->default(8728);
            $table->string('status')->default('offline');
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mikrotik_devices');
    }
};
EOF

cat << 'EOF' > database/migrations/2026_01_01_000002_create_hotspot_users_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotspot_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mikrotik_device_id')->constrained('mikrotik_devices')->onDelete('cascade');
            $table->string('username')->unique();
            $table->string('password')->nullable();
            $table->string('profile')->default('default');
            $table->string('limit_uptime')->default('00:00:00');
            $table->boolean('is_synced')->default(false);
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotspot_users');
    }
};
EOF

# 7. إنشاء النماذج (Models)
cat << 'EOF' > app/Models/MikroTikDevice.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MikroTikDevice extends Model
{
    use HasFactory;

    protected $table = 'mikrotik_devices';
    protected $fillable = ['title', 'ip_address', 'username', 'password', 'port', 'status', 'last_checked_at'];
    protected $casts = ['last_checked_at' => 'datetime'];

    public function hotspotUsers(): HasMany
    {
        return $this->hasMany(HotspotUser::class, 'mikrotik_device_id');
    }
}
EOF

cat << 'EOF' > app/Models/HotspotUser.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotspotUser extends Model
{
    use HasFactory;

    protected $table = 'hotspot_users';
    protected $fillable = ['mikrotik_device_id', 'username', 'password', 'profile', 'limit_uptime', 'is_synced', 'synced_at'];
    protected $casts = ['is_synced' => 'boolean', 'synced_at' => 'datetime'];

    public function device(): BelongsTo
    {
        return $this->belongsTo(MikroTikDevice::class, 'mikrotik_device_id');
    }
}
EOF

echo "✅ تم إنشاء هيكل المجلدات وكتابة كافة الملفات البرمجية بنجاح!"

# 8. تهيئة مستودع Git محلياً
git init
git add .
git commit -m "البنية الأساسية لنظام FaisalSoft - الاتصال والمزامنة"

echo "🎉 جاهز الآن للربط مع حسابك على GitHub!"