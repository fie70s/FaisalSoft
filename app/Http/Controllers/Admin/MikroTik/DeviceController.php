<?php

namespace App\Http\Controllers\Admin\MikroTik;

use App\Http\Controllers\Controller;
use App\Models\MikroTikDevice;
use App\Services\MikroTik\ApiService;
use App\Services\MikroTik\DeviceInfoService;
use Illuminate\Http\Request;


class DeviceController extends Controller
{

    protected $api;
    protected $info;


    public function __construct(
        ApiService $api,
        DeviceInfoService $info
    ) {
        $this->api = $api;
        $this->info = $info;
    }




    public function index()
    {
        $devices = MikroTikDevice::latest()->paginate(10);

        return view(
            'admin.mikrotik.devices.index',
            compact('devices')
        );
    }





    public function create()
    {
        return view('admin.mikrotik.devices.create');
    }





    public function store(Request $request)
    {

        $data = $request->validate([

            'name' => 'required|string|max:255',

            'serial_number' => 'nullable|string',

            'ip_address' => 'required|ip',

            'api_port' => 'nullable|integer',

            'username' => 'required|string',

            'password' => 'required|string',

            'router_model' => 'nullable|string',

            'router_os' => 'nullable|string',

            'license_level' => 'nullable|string',

            'owner' => 'nullable|string',

            'location' => 'nullable|string',

            'notes' => 'nullable|string',

        ]);



        $data['status'] = 'offline';


        MikroTikDevice::create($data);



        return redirect()
            ->route('admin.mikrotik.devices.index')
            ->with(
                'success',
                'Device added successfully'
            );

    }






    public function show(MikroTikDevice $device)
    {

        return view(
            'admin.mikrotik.devices.show',
            compact('device')
        );

    }






    public function edit(MikroTikDevice $device)
    {

        return view(
            'admin.mikrotik.devices.edit',
            compact('device')
        );

    }






    public function update(Request $request, MikroTikDevice $device)
    {

        $data = $request->validate([

            'name' => 'required|string|max:255',

            'serial_number' => 'nullable|string',

            'ip_address' => 'required|ip',

            'api_port' => 'nullable|integer',

            'username' => 'required|string',

            'password' => 'nullable|string',

            'router_model' => 'nullable|string',

            'router_os' => 'nullable|string',

            'license_level' => 'nullable|string',

            'owner' => 'nullable|string',

            'location' => 'nullable|string',

            'notes' => 'nullable|string',

        ]);



        if(empty($data['password'])) {

            unset($data['password']);

        }



        $device->update($data);



        return back()
            ->with(
                'success',
                'Device updated successfully'
            );

    }







    public function destroy(MikroTikDevice $device)
    {

        $device->delete();



        return redirect()
            ->route('admin.mikrotik.devices.index')
            ->with(
                'success',
                'Device deleted successfully'
            );

    }








    public function testConnection(MikroTikDevice $device)
    {

        $result = $this->api->testConnection($device);



        if($result) {


            $device->update([

                'status' => 'online',

                'last_seen' => now(),

            ]);



            return back()
                ->with(
                    'success',
                    'Connection successful'
                );

        }




        $device->update([

            'status' => 'offline'

        ]);



        return back()
            ->with(
                'error',
                'Connection failed'
            );

    }







    public function syncInfo(MikroTikDevice $device)
    {

        $result = $this->info->sync($device);



        if($result) {


            return back()
                ->with(
                    'success',
                    'Device information synchronized successfully'
                );

        }




        return back()
            ->with(
                'error',
                'Unable to synchronize device information'
            );

    }


}