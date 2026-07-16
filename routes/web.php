<?php

use App\Http\Controllers\Admin\MikroTik\DeviceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.mikrotik.devices');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/mikrotik/devices', [DeviceController::class, 'index'])->name('mikrotik.devices');
    Route::post('/mikrotik/devices', [DeviceController::class, 'store'])->name('mikrotik.devices.store');
});
