@extends('admin.layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">


    <div class="bg-white rounded-xl shadow p-6">


        <div class="flex justify-between items-center mb-6">


            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Edit MikroTik Device
                </h1>


                <p class="text-gray-500 mt-1">
                    Update device information
                </p>


            </div>



            <a href="{{ route('admin.mikrotik.devices.index') }}"
               class="bg-gray-200 px-5 py-3 rounded-lg">

                Back

            </a>


        </div>




        <form method="POST"
              action="{{ route('admin.mikrotik.devices.update',$device) }}">


            @csrf

            @method('PUT')



            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">



                <div>

                    <label class="block mb-2 font-semibold">
                        Device Name
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ $device->name }}"
                           class="w-full border rounded-lg p-3">

                </div>





                <div>

                    <label class="block mb-2 font-semibold">
                        IP Address
                    </label>

                    <input type="text"
                           name="ip_address"
                           value="{{ $device->ip_address }}"
                           class="w-full border rounded-lg p-3">

                </div>





                <div>

                    <label class="block mb-2 font-semibold">
                        API Port
                    </label>

                    <input type="number"
                           name="api_port"
                           value="{{ $device->api_port }}"
                           class="w-full border rounded-lg p-3">

                </div>





                <div>

                    <label class="block mb-2 font-semibold">
                        Username
                    </label>

                    <input type="text"
                           name="username"
                           value="{{ $device->username }}"
                           class="w-full border rounded-lg p-3">

                </div>





                <div>

                    <label class="block mb-2 font-semibold">
                        Password
                    </label>

                    <input type="password"
                           name="password"
                           placeholder="Leave empty to keep current password"
                           class="w-full border rounded-lg p-3">

                </div>





                <div>

                    <label class="block mb-2 font-semibold">
                        Serial Number
                    </label>

                    <input type="text"
                           name="serial_number"
                           value="{{ $device->serial_number }}"
                           class="w-full border rounded-lg p-3">

                </div>





                <div>

                    <label class="block mb-2 font-semibold">
                        Router Model
                    </label>

                    <input type="text"
                           name="router_model"
                           value="{{ $device->router_model }}"
                           class="w-full border rounded-lg p-3">

                </div>





                <div>

                    <label class="block mb-2 font-semibold">
                        RouterOS Version
                    </label>

                    <input type="text"
                           name="router_os"
                           value="{{ $device->router_os }}"
                           class="w-full border rounded-lg p-3">

                </div>





                <div>

                    <label class="block mb-2 font-semibold">
                        License Level
                    </label>

                    <input type="text"
                           name="license_level"
                           value="{{ $device->license_level }}"
                           class="w-full border rounded-lg p-3">

                </div>





                <div>

                    <label class="block mb-2 font-semibold">
                        Owner
                    </label>

                    <input type="text"
                           name="owner"
                           value="{{ $device->owner }}"
                           class="w-full border rounded-lg p-3">

                </div>





                <div>

                    <label class="block mb-2 font-semibold">
                        Location
                    </label>

                    <input type="text"
                           name="location"
                           value="{{ $device->location }}"
                           class="w-full border rounded-lg p-3">

                </div>



            </div>





            <div class="mt-6">


                <label class="block mb-2 font-semibold">
                    Notes
                </label>


                <textarea
                    name="notes"
                    class="w-full border rounded-lg p-3"
                    rows="4">{{ $device->notes }}</textarea>


            </div>






            <div class="mt-8">


                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">


                    <i class="fa-solid fa-save mr-2"></i>

                    Update Device


                </button>


            </div>



        </form>


    </div>


</div>


@endsection