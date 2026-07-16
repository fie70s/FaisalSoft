<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\MikroTik\DeviceController;
use App\Http\Controllers\Admin\Hotspot\UserController;



Route::get('/', function () {

    return view('welcome');

});




Route::get('/dashboard', function () {

    return view('dashboard');

})
->middleware(['auth', 'verified'])
->name('dashboard');





Route::middleware('auth')->group(function () {



    Route::get('/profile',
        [ProfileController::class, 'edit']
    )
    ->name('profile.edit');




    Route::patch('/profile',
        [ProfileController::class, 'update']
    )
    ->name('profile.update');




    Route::delete('/profile',
        [ProfileController::class, 'destroy']
    )
    ->name('profile.destroy');



});








Route::prefix('admin')
    ->middleware('auth')
    ->group(function () {



        Route::get('/dashboard',
            [DashboardController::class, 'index']
        )
        ->name('admin.dashboard');








        Route::resource(
            'products',
            ProductController::class
        )
        ->names('admin.products');










        Route::prefix('mikrotik')
            ->name('admin.mikrotik.')
            ->group(function () {



                Route::resource(
                    'devices',
                    DeviceController::class
                );





                Route::post(
                    'devices/{device}/test',
                    [DeviceController::class, 'testConnection']
                )
                ->name('devices.test');





                Route::post(
                    'devices/{device}/sync',
                    [DeviceController::class, 'syncInfo']
                )
                ->name('devices.sync');



            });









        Route::prefix('hotspot')
            ->name('admin.hotspot.')
            ->group(function () {





                Route::post(
                    'users/sync',
                    [UserController::class, 'sync']
                )
                ->name('users.sync');





                Route::get(
                    'users/{user}/sessions',
                    [UserController::class, 'sessions']
                )
                ->name('users.sessions');





                Route::post(
                    'users/sessions/{session}/disconnect',
                    [UserController::class, 'disconnect']
                )
                ->name('users.sessions.disconnect');







                Route::resource(
                    'users',
                    UserController::class
                )
                ->names('users');







                Route::post(
                    'users/{user}/enable',
                    [UserController::class, 'enable']
                )
                ->name('users.enable');







                Route::post(
                    'users/{user}/disable',
                    [UserController::class, 'disable']
                )
                ->name('users.disable');





            });





    });







require __DIR__.'/auth.php';