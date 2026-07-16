<?php

namespace App\Services\MikroTik;

use App\Models\MikroTikDevice;
use Exception;
use RouterOS\Client;
use RouterOS\Config;

class DeviceService
{
    public function registerDevice(array $data): MikroTikDevice
    {
        if (!$this->testConnection($data)) {
            throw new Exception('Unable to connect to MikroTik device.');
        }

        return MikroTikDevice::create([
            'name' => $data['title'],
            'ip_address' => $data['ip_address'],
            'api_port' => $data['port'] ?? 8728,
            'username' => $data['username'],
            'password' => $data['password'],
            'status' => 'online',
            'last_seen' => now(),
        ]);
    }

    public function testConnection(array $data): bool
    {
        try {
            $config = new Config();
            $config->set('host', $data['ip_address']);
            $config->set('user', $data['username']);
            $config->set('pass', $data['password']);
            $config->set('port', $data['port'] ?? 8728);

            new Client($config);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
