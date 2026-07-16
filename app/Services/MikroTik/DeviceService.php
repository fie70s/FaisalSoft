<?php

namespace App\Services\MikroTik;

use App\Models\MikroTikDevice;
use Exception;
use Illuminate\Support\Facades\Crypt;

class DeviceService
{
    public function __construct(
        protected RouterOSService $routerOSService
    ) {
    }

    public function registerDevice(array $data): MikroTikDevice
    {
        if (!$this->routerOSService->isConnected($data)) {
            throw new Exception('Unable to connect to MikroTik device.');
        }

        $system = $this->routerOSService->getSystemIdentity($data);

        return MikroTikDevice::create([
            'name' => $data['title'],
            'ip_address' => $data['ip_address'],
            'api_port' => $data['port'] ?? 8728,
            'username' => $data['username'],
            'password' => Crypt::encryptString($data['password']),
            'router_model' => $system['board-name'] ?? null,
            'router_os' => $system['version'] ?? null,
            'status' => 'online',
            'last_seen' => now(),
        ]);
    }
}
