<?php

namespace App\Services\MikroTik\Hotspot;

use App\Models\HotspotUser;
use App\Models\MikroTikDevice;
use App\Services\MikroTik\ApiService;
use RouterOS\Query;


class HotspotUserSyncService
{

    protected ApiService $api;



    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }





    public function sync(MikroTikDevice $device): int
    {

        $client = $this->api->connect($device);



        $query = new Query('/ip/hotspot/user/print');



        $users = $client
            ->query($query)
            ->read();



        $count = 0;



        foreach($users as $user)
        {


            if(!isset($user['.id']))
            {
                continue;
            }



            HotspotUser::updateOrCreate(

                [

                    'mikrotik_device_id' =>
                    $device->id,


                    'mikrotik_id' =>
                    $user['.id'],

                ],


                [

                    'username' =>
                    $user['name'] ?? null,


                    'profile' =>
                    $user['profile'] ?? null,


                    'comment' =>
                    $user['comment'] ?? null,


                    'limit_uptime' =>
                    $user['limit-uptime'] ?? null,


                    'limit_bytes_total' =>
                    isset($user['limit-bytes-total'])
                    ? (int)$user['limit-bytes-total']
                    : null,


                    'bytes_in' =>
                    isset($user['bytes-in'])
                    ? (int)$user['bytes-in']
                    : 0,


                    'bytes_out' =>
                    isset($user['bytes-out'])
                    ? (int)$user['bytes-out']
                    : 0,


                    'uptime' =>
                    $user['uptime'] ?? null,


                    'disabled' =>
                    ($user['disabled'] ?? 'false') === 'true',


                    'extra' =>
                    $user,

                ]

            );



            $count++;

        }



        return $count;

    }

}