<?php

namespace App\Http\Controllers\Admin\MikroTik;

use App\Http\Controllers\Controller;
use App\Models\MikroTikDevice;
use App\Services\MikroTik\DeviceService;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    protected $deviceService;

    public function __construct(DeviceService $deviceService)
    {
        $this->deviceService = $deviceService;
    }

    public function index()
    {
        $devices = MikroTikDevice::withCount('hotspotUsers')->get();
        return view('admin.mikrotik.devices', compact('devices'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'ip_address' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
            'port' => 'nullable|integer',
        ]);

        $this->deviceService->registerDevice($data);
        return redirect()->back()->with('success', 'تم إضافة جهاز الميكروتك وفحص الاتصال بنجاح!');
    }
}
