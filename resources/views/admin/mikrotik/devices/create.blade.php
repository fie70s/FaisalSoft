@extends('admin.layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">


    <div class="bg-white rounded-xl shadow p-6">


        <div class="flex justify-between items-center mb-6">


            <div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Add MikroTik Device
                </h1>


                <p class="text-gray-500 mt-1">
                    Register new MikroTik device
                </p>


            </div>



            <a href="{{ route('admin.mikrotik.devices.index') }}"
               class="bg-gray-200 px-5 py-3 rounded-lg">

                Back

            </a>


        </div>






        <form method="POST"
              action="{{ route('admin.mikrotik.devices.store') }}">

            @csrf



            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">



                <div>

                    <label class="block mb-2 font-semibold">
                        Device Name
                    </label>

                    <input type="text"
                           name="name"
                           placeholder="Example: spics x"
                           class="w-full border rounded-lg p-3"
                           required>

                </div>





                <div>

                    <label class="block mb-2 font-semibold">
                        Serial Number
                    </label>

                    <input type="text"
                           name="serial_number"
                           placeholder="Example: HFH0926K8AK"
                           class="w-full border rounded-lg p-3">

                </div>





                <div>

                    <label class="block mb-2 font-semibold">
                        IP Address
                    </label>

                    <input type="text"
                           name="ip_address"
                           placeholder="10.10.10.1"
                           class="w-full border rounded-lg p-3"
                           required>

                </div>





                <div>

                    <label class="block mb-2 font-semibold">
                        API Port
                    </label>

                    <input type="number"
                           name="api_port"
                           value="8728"
                           class="w-full border rounded-lg p-3">

                </div>





                <div>

                    <label class="block mb-2 font-semibold">
                        Username
                    </label>

                    <input type="text"
                           name="username"
                           placeholder="admin"
                           class="w-full border rounded-lg p-3"
                           required>

                </div>





                <div>

                    <label class="block mb-2 font-semibold">
                        Password
                    </label>

                    <input type="password"
                           name="password"
                           class="w-full border rounded-lg p-3"
                           required>

                </div>







                <div>

                    <label class="block mb-2 font-semibold">
                        Router Model
                    </label>

                    <input type="text"
                           name="router_model"
                           placeholder="Example: RB1100AHx4 Dude Edition"
                           class="w-full border rounded-lg p-3">

                </div>







                <div>

                    <label class="block mb-2 font-semibold">
                        RouterOS Version
                    </label>

                    <input type="text"
                           name="router_os"
                           placeholder="Example: 6.49.20 (long-term)"
                           class="w-full border rounded-lg p-3">

                </div>







                <div>

                    <label class="block mb-2 font-semibold">
                        License Level
                    </label>

                    <input type="text"
                           name="license_level"
                           placeholder="Example: 6"
                           class="w-full border rounded-lg p-3">

                </div>







                <div>

                    <label class="block mb-2 font-semibold">
                        Owner
                    </label>

                    <input type="text"
                           name="owner"
                           class="w-full border rounded-lg p-3">

                </div>







                <div>

                    <label class="block mb-2 font-semibold">
                        Location
                    </label>

                    <input type="text"
                           name="location"
                           class="w-full border rounded-lg p-3">

                </div>



            </div>






            <div class="mt-6">


                <label class="block mb-2 font-semibold">
                    Notes
                </label>


                <textarea
                    name="notes"
                    rows="4"
                    class="w-full border rounded-lg p-3"></textarea>


            </div>







            <div class="mt-8">


                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">


                    <i class="fa-solid fa-plus mr-2"></i>

                    Save Device


                </button>


            </div>




        </form>


    </div>


</div>


@endsection