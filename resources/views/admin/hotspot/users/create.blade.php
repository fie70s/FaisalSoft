@extends('admin.layouts.app')

@section('content')

<div class="space-y-6">

    <div class="flex justify-between items-center">

        <div>

            <h2 class="text-2xl font-bold">
                إضافة مستخدم Hotspot
            </h2>

            <p class="text-gray-500">
                إنشاء مستخدم جديد على MikroTik Hotspot
            </p>

        </div>


        <a href="{{ route('admin.hotspot.users.index') }}"
           class="bg-gray-600 text-white px-4 py-2 rounded">

            رجوع

        </a>

    </div>




    @if($errors->any())

        <div class="bg-red-100 text-red-700 p-4 rounded">

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif





    <div class="bg-white rounded shadow p-6">


        <form method="POST"
              action="{{ route('admin.hotspot.users.store') }}">

            @csrf




            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">



                <div>

                    <label class="block mb-2 font-bold">

                        Username

                    </label>


                    <input

                        type="text"

                        name="username"

                        value="{{ old('username') }}"

                        class="w-full border rounded p-2"

                        required

                    >

                </div>





                <div>

                    <label class="block mb-2 font-bold">

                        Password

                    </label>


                    <input

                        type="text"

                        name="password"

                        value="{{ old('password') }}"

                        class="w-full border rounded p-2"

                        placeholder="اختياري"

                    >

                    <small class="text-gray-500">

                        يمكن تركه فارغاً

                    </small>


                </div>





                <div>

                    <label class="block mb-2 font-bold">

                        Profile

                    </label>



                    <select

                        name="profile"

                        class="w-full border rounded p-2">


                        <option value="">

                            اختر البروفايل

                        </option>



                        @foreach($profiles as $profile)


                            <option value="{{ $profile }}"

                            {{ old('profile')==$profile?'selected':'' }}>


                                {{ $profile }}


                            </option>


                        @endforeach



                    </select>


                </div>






                <div>

                    <label class="block mb-2 font-bold">

                        Limit Uptime

                    </label>



                    <input

                        type="text"

                        name="limit_uptime"

                        value="{{ old('limit_uptime') }}"

                        class="w-full border rounded p-2"

                        placeholder="مثال: 4w2d"

                    >


                </div>







                <div>

                    <label class="block mb-2 font-bold">

                        Limit Bytes Total

                    </label>



                    <input

                        type="number"

                        name="limit_bytes_total"

                        value="{{ old('limit_bytes_total') }}"

                        class="w-full border rounded p-2"

                        placeholder="مثال: 30000000000"

                    >



                    <small class="text-gray-500">

                        القيمة بالـ Bytes

                    </small>


                </div>







                <div>

                    <label class="block mb-2 font-bold">

                        Comment

                    </label>



                    <input

                        type="text"

                        name="comment"

                        value="{{ old('comment') }}"

                        class="w-full border rounded p-2"

                    >


                </div>




            </div>






            <button

                type="submit"

                class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded">


                حفظ المستخدم


            </button>



        </form>


    </div>


</div>


@endsection