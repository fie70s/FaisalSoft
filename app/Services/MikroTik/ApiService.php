<?php

namespace App\Services\MikroTik;

use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;
use Exception;


class ApiService
{

    public function connect($device)
    {

        try {

            $config = new Config([
                'host' => $device->ip_address,
                'user' => $device->username,
                'pass' => $device->password,
                'port' => $device->api_port ?? 8728,
            ]);


            return new Client($config);


        } catch (Exception $e) {

            return false;

        }

    }




    public function testConnection($device)
    {

        $client = $this->connect($device);


        if (!$client) {

            return false;

        }



        try {


            $query = new Query('/system/resource/print');


            $response = $client->query($query)->read();


            return !empty($response);



        } catch (Exception $e) {


            return false;


        }


    }

}