<?php

namespace App\Services\MikroTik;

use RouterOS\Client;
use RouterOS\Config;
use Exception;

class RouterOSService
{
    protected function client(array $device): Client
    {
        $config = new Config();
        $config->set('host', $device['ip_address']);
        $config->set('user', $device['username']);
        $config->set('pass', $device['password']);
        $config->set('port', $device['api_port'] ?? 8728);

        return new Client($config);
    }

    public function getSystemIdentity(array $device): array
    {
        try {
            $client = $this->client($device);

            $response = $client->query('/system/resource/print')->read();

            return $response[0] ?? [];
        } catch (Exception $e) {
            return [];
        }
    }

    public function isConnected(array $device): bool
    {
        try {
            $this->client($device);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
