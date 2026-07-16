@extends('admin.layouts.app')

@section('content')

<div class="space-y-6">


    <div class="flex justify-between items-center">


        <div>

            <h2 class="text-2xl font-bold">
                تعديل مستخدم Hotspot
            </h2>

            <p class="text-gray-500">
                تعديل بيانات مستخدم MikroTik
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
              action="{{ route('admin.hotspot.users.update',$user->mikrotik_id) }}">


            @csrf

            @method('PUT')





            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">





                <div>

                    <label class="block mb-2 font-bold">
                        Username
                    </label>


                    <input

                        type="text"

                        value="{{ $user->username }}"

                        class="w-full border rounded p-2 bg-gray-100"

                        readonly

                    >


                </div>






                <div>

                    <label class="block mb-2 font-bold">

                        Password

                    </label>



                    <input

                        type="text"

                        name="password"

                        class="w-full border rounded p-2"

                        placeholder="اتركه فارغاً بدون تغيير"

                    >


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


                            <option

                                value="{{ $profile }}"

                                {{ $user->profile == $profile ? 'selected' : '' }}

                            >

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

                        value="{{ $user->limit_uptime }}"

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

                        value="{{ $user->limit_bytes_total }}"

                        class="w-full border rounded p-2"

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

                        value="{{ $user->comment }}"

                        class="w-full border rounded p-2"

                    >


                </div>



            </div>







            <div class="mt-6 bg-gray-100 rounded p-4">


                <h3 class="font-bold mb-3">

                    إحصائيات المستخدم

                </h3>



                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">



                    <div>

                        التحميل:

                        <strong>

                            {{ number_format($user->bytes_in) }}

                        </strong>


                    </div>




                    <div>

                        الرفع:

                        <strong>

                            {{ number_format($user->bytes_out) }}

                        </strong>


                    </div>





                    <div>

                        الوقت المستخدم:

                        <strong>

                            {{ $user->uptime ?? '0s' }}

                        </strong>


                    </div>



                </div>


            </div>







            <button

                type="submit"

                class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded">


                حفظ التعديل


            </button>



        </form>


    </div>


</div>


@endsection