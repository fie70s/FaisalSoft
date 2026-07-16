@extends('admin.layouts.app')

@section('content')

<div class="space-y-6">


    <!-- Header -->

    <div class="flex justify-between items-center">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                MikroTik Devices
            </h1>

            <p class="text-gray-500 mt-1">
                Manage all MikroTik devices connected to FaisalSoft
            </p>

        </div>


        <a href="{{ route('admin.mikrotik.devices.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow">

            <i class="fa-solid fa-plus mr-2"></i>

            Add Device

        </a>

    </div>




    <!-- Messages -->

    @if(session('success'))

        <div class="bg-green-100 text-green-700 p-4 rounded-lg">

            {{ session('success') }}

        </div>

    @endif





    <!-- Statistics -->

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


        <div class="bg-white rounded-xl shadow p-6">

            <p class="text-gray-500">
                Total Devices
            </p>

            <h2 class="text-3xl font-bold mt-2">
                {{ $devices->total() }}
            </h2>

        </div>



        <div class="bg-white rounded-xl shadow p-6">

            <p class="text-gray-500">
                Online
            </p>

            <h2 class="text-3xl font-bold text-green-600 mt-2">

                {{ $devices->where('status','online')->count() }}

            </h2>

        </div>



        <div class="bg-white rounded-xl shadow p-6">

            <p class="text-gray-500">
                Offline
            </p>

            <h2 class="text-3xl font-bold text-red-600 mt-2">

                {{ $devices->where('status','offline')->count() }}

            </h2>

        </div>


    </div>






    <!-- Table -->

    <div class="bg-white rounded-xl shadow overflow-hidden">


        <div class="overflow-x-auto">


            <table class="w-full">


                <thead class="bg-gray-100">


                    <tr>


                        <th class="p-4 text-left">
                            Name
                        </th>


                        <th class="p-4 text-left">
                            IP Address
                        </th>


                        <th class="p-4 text-left">
                            Model
                        </th>


                        <th class="p-4 text-left">
                            Status
                        </th>


                        <th class="p-4 text-left">
                            Actions
                        </th>


                    </tr>


                </thead>




                <tbody>


                @forelse($devices as $device)


                    <tr class="border-b">


                        <td class="p-4 font-semibold">

                            {{ $device->name }}

                        </td>


                        <td class="p-4">

                            {{ $device->ip_address }}

                        </td>


                        <td class="p-4">

                            {{ $device->router_model ?? '-' }}

                        </td>


                        <td class="p-4">


                            @if($device->status === 'online')

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                                    Online

                                </span>

                            @else

                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">

                                    Offline

                                </span>

                            @endif


                        </td>



                        <td class="p-4">


                            <a href="{{ route('admin.mikrotik.devices.show',$device) }}"
                               class="text-blue-600 mr-3">

                                <i class="fa-solid fa-eye"></i>

                            </a>



                            <a href="{{ route('admin.mikrotik.devices.edit',$device) }}"
                               class="text-yellow-600 mr-3">

                                <i class="fa-solid fa-pen"></i>

                            </a>




                            <form action="{{ route('admin.mikrotik.devices.destroy',$device) }}"
                                  method="POST"
                                  class="inline">


                                @csrf

                                @method('DELETE')


                                <button class="text-red-600">

                                    <i class="fa-solid fa-trash"></i>

                                </button>


                            </form>


                        </td>


                    </tr>



                @empty


                    <tr>

                        <td colspan="5"
                            class="p-6 text-center text-gray-500">

                            No MikroTik devices found.

                        </td>

                    </tr>


                @endforelse


                </tbody>


            </table>


        </div>


    </div>



    <div>

        {{ $devices->links() }}

    </div>



</div>


@endsection