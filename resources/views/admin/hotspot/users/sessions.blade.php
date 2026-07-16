@extends('admin.layouts.app')


@section('content')


<div class="mb-6">

    <h2 class="text-2xl font-bold">
        الجلسات النشطة
    </h2>


    <p class="text-gray-500">
        المستخدم:
        {{ $user->username }}
    </p>

</div>





<a href="{{ route('admin.hotspot.users.index') }}"
   class="bg-gray-600 text-white px-4 py-2 rounded">

    رجوع

</a>







@if(session('success'))

<div class="bg-green-100 text-green-700 p-3 rounded my-4">

    {{ session('success') }}

</div>

@endif







<div class="overflow-x-auto mt-6">


<table class="w-full border">


<thead class="bg-gray-100">


<tr>

<th class="border p-3">
#
</th>


<th class="border p-3">
Session ID
</th>


<th class="border p-3">
IP Address
</th>


<th class="border p-3">
MAC Address
</th>


<th class="border p-3">
Uptime
</th>


<th class="border p-3">
Download
</th>


<th class="border p-3">
Upload
</th>


<th class="border p-3">
الإجراء
</th>


</tr>


</thead>





<tbody>



@forelse($sessions as $index=>$session)



<tr>


<td class="border p-3">

{{ $index + 1 }}

</td>





<td class="border p-3">

{{ $session['.id'] ?? '-' }}

</td>





<td class="border p-3">

{{ $session['address'] ?? '-' }}

</td>





<td class="border p-3">

{{ $session['mac-address'] ?? '-' }}

</td>





<td class="border p-3">

{{ $session['uptime'] ?? '0s' }}

</td>





<td class="border p-3">

{{ $session['bytes-in'] ?? 0 }}

</td>





<td class="border p-3">

{{ $session['bytes-out'] ?? 0 }}

</td>





<td class="border p-3">


<form method="POST"
      action="{{ route('admin.hotspot.users.sessions.disconnect',$session['.id']) }}">


@csrf


<button type="submit"

class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">

قطع الاتصال

</button>


</form>


</td>




</tr>




@empty


<tr>

<td colspan="8"
    class="border p-5 text-center">

لا توجد جلسات نشطة

</td>

</tr>


@endforelse




</tbody>


</table>


</div>




@endsection