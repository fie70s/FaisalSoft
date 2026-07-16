@extends('admin.layouts.app')

@section('content')

@php

function formatBytes($bytes)
{
    if (!$bytes || $bytes <= 0) {
        return '0 B';
    }

    $units = [
        'B',
        'KB',
        'MB',
        'GB',
        'TB'
    ];

    $i = floor(log($bytes, 1024));

    return round(
        $bytes / pow(1024, $i),
        2
    ) . ' ' . $units[$i];
}


function usagePercent($used, $limit)
{
    if (!$limit || $limit <= 0) {
        return 0;
    }

    return min(
        100,
        round(($used / $limit) * 100)
    );
}

@endphp


<div class="flex justify-between items-center mb-6">

    <div>

        <h1 class="text-3xl font-bold">
            Hotspot Users
        </h1>

        <p class="text-gray-500">
            إدارة مستخدمي MikroTik Hotspot
        </p>

    </div>


    <a href="{{ route('admin.hotspot.users.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

        + إضافة مستخدم

    </a>

</div>



@if(session('success'))

<div class="bg-green-100 text-green-700 p-3 rounded mb-4">

{{ session('success') }}

</div>

@endif



@if(session('error'))

<div class="bg-red-100 text-red-700 p-3 rounded mb-4">

{{ session('error') }}

</div>

@endif



@if(isset($error) && $error)

<div class="bg-red-100 text-red-700 p-3 rounded mb-4">

{{ $error }}

</div>

@endif



@if($device)

<div class="bg-gray-100 p-4 rounded mb-5">

<strong>
الجهاز:
</strong>

{{ $device->name }}

&nbsp;&nbsp;


<strong>
IP:
</strong>

{{ $device->ip_address }}


&nbsp;&nbsp;


<strong>
Serial:
</strong>

{{ $device->serial_number }}

</div>

@endif



<form method="GET"
      class="flex flex-wrap gap-3 mb-6">


<input
type="text"
name="search"
value="{{ request('search') }}"
placeholder="بحث عن مستخدم..."
class="border rounded-lg px-3 py-2">


<select
name="status"
class="border rounded-lg px-3 py-2">


<option value="">
كل الحالات
</option>


<option value="active"
@selected(request('status')=='active')>

فعال

</option>


<option value="disabled"
@selected(request('status')=='disabled')>

معطل

</option>


</select>



<select
name="profile"
class="border rounded-lg px-3 py-2">


<option value="">
كل البروفايلات
</option>


@foreach($profiles ?? [] as $profile)

<option value="{{ $profile }}"
@selected(request('profile')==$profile)>

{{ $profile }}

</option>

@endforeach


</select>



<select
name="package"
class="border rounded-lg px-3 py-2">


<option value="">
كل المستخدمين
</option>


<option value="limited"
@selected(request('package')=='limited')>

لديهم باقة

</option>


<option value="unlimited"
@selected(request('package')=='unlimited')>

بدون باقة

</option>


</select>



<button
class="bg-gray-800 text-white px-5 py-2 rounded-lg">

بحث

</button>


</form><div class="overflow-x-auto bg-white rounded-lg shadow">


<table class="w-full text-sm text-right">


<thead class="bg-gray-100">


<tr>


<th class="p-3">
#
</th>


<th class="p-3">
Username
</th>


<th class="p-3">
Profile
</th>


<th class="p-3">
Comment
</th>


<th class="p-3">
Download
</th>


<th class="p-3">
Upload
</th>


<th class="p-3">
Total
</th>


<th class="p-3">
Usage
</th>


<th class="p-3">
Uptime
</th>


<th class="p-3">
Status
</th>


<th class="p-3">
Actions
</th>


</tr>


</thead>



<tbody>



@forelse($users as $index=>$user)


@php

$used =
($user->bytes_in ?? 0)
+
($user->bytes_out ?? 0);


$percent =
usagePercent(
    $used,
    $user->limit_bytes_total
);

@endphp



<tr class="border-b">


<td class="p-3">

{{ $users->firstItem() + $index }}

</td>



<td class="p-3 font-bold">

{{ $user->username ?? '-' }}

</td>



<td class="p-3">

{{ $user->profile ?? '-' }}

</td>



<td class="p-3">

{{ $user->comment ?? '-' }}

</td>



<td class="p-3">

{{ formatBytes($user->bytes_in ?? 0) }}

</td>



<td class="p-3">

{{ formatBytes($user->bytes_out ?? 0) }}

</td>



<td class="p-3">

{{ formatBytes($used) }}

</td>



<td class="p-3">


@if($user->limit_bytes_total)


<div class="w-32 bg-gray-200 rounded-full h-3">


<div

class="h-3 rounded-full

@if($percent < 70)

bg-green-500

@elseif($percent < 90)

bg-yellow-500

@else

bg-red-500

@endif"

style="width: {{ $percent }}%">

</div>


</div>


<span>

{{ $percent }}%

</span>


@else


<span>

غير محدد

</span>


@endif


</td>




<td class="p-3">

{{ $user->uptime ?? '0s' }}

</td>




<td class="p-3">


@if($user->disabled)


<span class="text-red-600">

معطل

</span>


@else


<span class="text-green-600">

فعال

</span>


@endif


</td>




<td class="p-3">


<div class="flex gap-2 flex-wrap">



<a href="{{ route('admin.hotspot.users.edit',$user->mikrotik_id) }}"

class="bg-yellow-500 text-white px-3 py-1 rounded">


تعديل


</a>




<a href="{{ route('admin.hotspot.users.sessions',$user->mikrotik_id) }}"

class="bg-purple-600 text-white px-3 py-1 rounded">


الجلسات


</a>





@if($user->disabled)


<form method="POST"

action="{{ route('admin.hotspot.users.enable',$user->mikrotik_id) }}">


@csrf


<button

class="bg-green-600 text-white px-3 py-1 rounded">


تفعيل


</button>


</form>



@else



<form method="POST"

action="{{ route('admin.hotspot.users.disable',$user->mikrotik_id) }}">


@csrf


<button

class="bg-orange-600 text-white px-3 py-1 rounded">


تعطيل


</button>


</form>



@endif





<form method="POST"

action="{{ route('admin.hotspot.users.destroy',$user->mikrotik_id) }}">


@csrf

@method('DELETE')



<button

onclick="return confirm('هل تريد حذف المستخدم؟')"

class="bg-red-600 text-white px-3 py-1 rounded">


حذف


</button>


</form>



</div>


</td>


</tr>



@empty


<tr>

<td colspan="11"

class="p-5 text-center text-gray-500">


لا يوجد مستخدمون


</td>

</tr>



@endforelse



</tbody>


</table>


</div>




<div class="mt-5">

{{ $users->links() }}

</div>



@endsection
