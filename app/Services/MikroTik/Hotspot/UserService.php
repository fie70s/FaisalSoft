<?php

namespace App\Services\MikroTik\Hotspot;

use App\Models\MikroTikDevice;
use App\Services\MikroTik\ApiService;
use RouterOS\Query;


class UserService
{

    protected ApiService $api;



    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }





    public function all(MikroTikDevice $device): array
    {

        $client = $this->api->connect($device);



        $query = new Query('/ip/hotspot/user/print');



        return $client
            ->query($query)
            ->read();

    }








    public function profiles(MikroTikDevice $device): array
    {

        $client = $this->api->connect($device);



        $query = new Query('/ip/hotspot/user/profile/print');



        $result = $client
            ->query($query)
            ->read();



        $profiles = [];



        foreach($result as $profile)
        {

            if(isset($profile['name']))
            {

                $profiles[] = $profile['name'];

            }

        }



        return $profiles;

    }








    public function find(
        MikroTikDevice $device,
        string $id
    ): array
    {

        $users = $this->all($device);



        foreach($users as $user)
        {

            if(
                isset($user['.id']) &&
                $user['.id'] == $id
            )
            {

                return $user;

            }

        }



        return [];

    }









    public function create(
        MikroTikDevice $device,
        array $data
    ): bool
    {

        $client = $this->api->connect($device);



        $query = new Query(
            '/ip/hotspot/user/add'
        );



        $query->equal(
            'name',
            $data['username']
        );




        if(
            isset($data['password']) &&
            $data['password'] !== ''
        )
        {

            $query->equal(
                'password',
                $data['password']
            );

        }







        $fields = [

            'profile',

            'comment',

            'limit-uptime',

            'limit-bytes-total',

        ];




        foreach($fields as $field)
        {

            if(
                isset($data[$field]) &&
                $data[$field] !== null &&
                $data[$field] !== ''
            )
            {

                $query->equal(
                    $field,
                    $data[$field]
                );

            }

        }





        $client
            ->query($query)
            ->read();



        return true;

    }









    public function update(
        MikroTikDevice $device,
        string $id,
        array $data
    ): bool
    {

        $client = $this->api->connect($device);



        $query = new Query(
            '/ip/hotspot/user/set'
        );



        $query->equal(
            '.id',
            $id
        );





        foreach($data as $key=>$value)
        {


            if(
                $value !== null &&
                $value !== ''
            )
            {

                $query->equal(
                    $key,
                    $value
                );

            }


        }





        $client
            ->query($query)
            ->read();



        return true;

    }









    public function delete(
        MikroTikDevice $device,
        string $id
    ): bool
    {

        $client = $this->api->connect($device);



        $query = new Query(
            '/ip/hotspot/user/remove'
        );



        $query->equal(
            '.id',
            $id
        );



        $client
            ->query($query)
            ->read();



        return true;

    }









    public function disable(
        MikroTikDevice $device,
        string $id
    ): bool
    {

        return $this->setDisabled(
            $device,
            $id,
            true
        );

    }









    public function enable(
        MikroTikDevice $device,
        string $id
    ): bool
    {

        return $this->setDisabled(
            $device,
            $id,
            false
        );

    }









    protected function setDisabled(
        MikroTikDevice $device,
        string $id,
        bool $status
    ): bool
    {

        $client = $this->api->connect($device);



        $query = new Query(
            '/ip/hotspot/user/set'
        );



        $query->equal(
            '.id',
            $id
        );



        $query->equal(
            'disabled',
            $status ? 'true' : 'false'
        );



        $client
            ->query($query)
            ->read();



        return true;

    }









    public function activeSessions(
        MikroTikDevice $device,
        string $username = null
    ): array
    {

        $client = $this->api->connect($device);



        $query = new Query(
            '/ip/hotspot/active/print'
        );



        if($username)
        {

            $query->where(
                'user',
                $username
            );

        }



        return $client
            ->query($query)
            ->read();

    }









    public function disconnect(
        MikroTikDevice $device,
        string $id
    ): bool
    {

        $client = $this->api->connect($device);



        $query = new Query(
            '/ip/hotspot/active/remove'
        );



        $query->equal(
            '.id',
            $id
        );



        $client
            ->query($query)
            ->read();



        return true;

    }


}