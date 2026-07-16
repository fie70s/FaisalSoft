@extends('admin.layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">


    <div>

        <h2 class="text-2xl font-bold">
            تفاصيل مستخدم Hotspot
        </h2>


        <p class="text-gray-500">
            عرض معلومات المستخدم من MikroTik
        </p>

    </div>




    <a href="{{ route('admin.hotspot.users.index') }}"
       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">

        رجوع

    </a>


</div>





<div class="bg-white rounded-lg shadow p-6">


<div class="grid grid-cols-2 gap-5">



<div class="border rounded p-4">

<p class="text-gray-500">
Username
</p>

<h3 class="font-bold text-lg">

{{ $user['name'] ?? '-' }}

</h3>

</div>






<div class="border rounded p-4">

<p class="text-gray-500">
Profile
</p>

<h3 class="font-bold text-lg">

{{ $user['profile'] ?? '-' }}

</h3>

</div>






<div class="border rounded p-4">

<p class="text-gray-500">
Comment
</p>

<h3 class="font-bold text-lg">

{{ $user['comment'] ?? '-' }}

</h3>

</div>







<div class="border rounded p-4">

<p class="text-gray-500">
Status
</p>


@if(($user['disabled'] ?? 'no') == 'yes')

<span class="bg-red-100 text-red-700 px-3 py-1 rounded">

معطل

</span>


@else


<span class="bg-green-100 text-green-700 px-3 py-1 rounded">

فعال

</span>


@endif


</div>








<div class="border rounded p-4">

<p class="text-gray-500">

MAC Address

</p>


<h3 class="font-bold">

{{ $user['mac-address'] ?? '-' }}

</h3>


</div>







<div class="border rounded p-4">

<p class="text-gray-500">

Address

</p>


<h3 class="font-bold">

{{ $user['address'] ?? '-' }}

</h3>


</div>



</div>





<div class="mt-6 flex gap-3">


<a href="{{ route('admin.hotspot.users.edit',$user['.id']) }}"
class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded">

تعديل

</a>





<form method="POST"
action="{{ route('admin.hotspot.users.destroy',$user['.id']) }}"
onsubmit="return confirm('هل أنت متأكد من حذف المستخدم؟')">


@csrf

@method('DELETE')


<button class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded">

حذف

</button>


</form>



</div>



</div>


@endsection