@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">


    <div class="flex justify-between items-center">


        <div>

            <h1 class="text-3xl font-bold text-gray-800">

                {{ $device->name }}

            </h1>


            <p class="text-gray-500 mt-1">

                MikroTik Device Details

            </p>

        </div>




        <a href="{{ route('admin.mikrotik.devices.index') }}"
           class="bg-gray-200 hover:bg-gray-300 px-5 py-3 rounded-lg">

            Back

        </a>


    </div>





    @if(session('success'))

        <div class="bg-green-100 text-green-700 p-4 rounded-lg">

            {{ session('success') }}

        </div>

    @endif




    @if(session('error'))

        <div class="bg-red-100 text-red-700 p-4 rounded-lg">

            {{ session('error') }}

        </div>

    @endif






    <!-- Status -->


    <div class="bg-white rounded-xl shadow p-6">


        <div class="flex justify-between items-center">


            <div>

                <h2 class="text-xl font-bold">
                    Connection Status
                </h2>


                <p class="text-gray-500">
                    Current MikroTik status
                </p>


            </div>




            @if($device->status == 'online')

                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full">

                    Online

                </span>


            @else


                <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full">

                    Offline

                </span>


            @endif



        </div>


    </div>







    <!-- Information -->


    <div class="bg-white rounded-xl shadow p-6">


        <h2 class="text-xl font-bold mb-6">

            Device Information

        </h2>




        <div class="grid md:grid-cols-2 gap-6">



            <div>

                <p class="text-gray-500">
                    IP Address
                </p>

                <p class="font-bold">
                    {{ $device->ip_address }}
                </p>

            </div>





            <div>

                <p class="text-gray-500">
                    API Port
                </p>

                <p class="font-bold">
                    {{ $device->api_port }}
                </p>

            </div>





            <div>

                <p class="text-gray-500">
                    Serial Number
                </p>

                <p class="font-bold">
                    {{ $device->serial_number ?? '-' }}
                </p>

            </div>





            <div>

                <p class="text-gray-500">
                    Router Model
                </p>

                <p class="font-bold">
                    {{ $device->router_model ?? '-' }}
                </p>

            </div>





            <div>

                <p class="text-gray-500">
                    RouterOS Version
                </p>

                <p class="font-bold">
                    {{ $device->router_os ?? '-' }}
                </p>

            </div>





            <div>

                <p class="text-gray-500">
                    License Level
                </p>

                <p class="font-bold">
                    {{ $device->license_level ?? '-' }}
                </p>

            </div>





            <div>

                <p class="text-gray-500">
                    Last Seen
                </p>

                <p class="font-bold">
                    {{ $device->last_seen ?? 'Never' }}
                </p>

            </div>




        </div>


    </div>








    <!-- Actions -->


    <div class="bg-white rounded-xl shadow p-6">


        <h2 class="text-xl font-bold mb-5">

            Actions

        </h2>




        <div class="flex flex-wrap gap-3">





            <form method="POST"
                  action="{{ route('admin.mikrotik.devices.test',$device) }}">

                @csrf


                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">


                    <i class="fa-solid fa-plug mr-2"></i>

                    Test Connection


                </button>


            </form>







            <form method="POST"
                  action="{{ route('admin.mikrotik.devices.sync',$device) }}">

                @csrf


                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg">


                    <i class="fa-solid fa-rotate mr-2"></i>

                    Sync Device Info


                </button>


            </form>





            <button class="bg-purple-600 text-white px-5 py-3 rounded-lg">

                <i class="fa-solid fa-chart-line mr-2"></i>

                Monitoring

            </button>





        </div>


    </div>





</div>


@endsection