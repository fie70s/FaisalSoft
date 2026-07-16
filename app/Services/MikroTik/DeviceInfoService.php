<?php

namespace App\Services\MikroTik;

use App\Models\MikroTikDevice;
use RouterOS\Query;
use Exception;


class DeviceInfoService
{

    protected $api;


    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }



    public function sync(MikroTikDevice $device)
    {

        $client = $this->api->connect($device);


        if(!$client){

            return false;

        }



        try {


            $resource = $client
                ->query(
                    new Query('/system/resource/print')
                )
                ->read();



            $routerboard = $client
                ->query(
                    new Query('/system/routerboard/print')
                )
                ->read();



            $license = $client
                ->query(
                    new Query('/system/license/print')
                )
                ->read();




            $data = [];




            if(isset($resource[0])){


                $data['router_os'] =
                    $resource[0]['version'] ?? null;


            }





            if(isset($routerboard[0])){


                $data['router_model'] =
                    $routerboard[0]['board-name']
                    ?? $routerboard[0]['model']
                    ?? null;



                $data['serial_number'] =
                    $routerboard[0]['serial-number']
                    ?? null;


            }






            if(isset($license[0])){


                $data['license_level'] =
                    $license[0]['level']
                    ?? null;


            }




            $device->update($data);



            return $data;



        } catch(Exception $e){


            return false;


        }


    }

}