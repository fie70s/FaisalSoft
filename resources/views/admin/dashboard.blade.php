@extends('admin.layouts.app')


@section('content')


<div class="mb-6">

    <h1 class="text-3xl font-bold text-gray-800">
        Admin Dashboard
    </h1>


    <p class="text-gray-500 mt-1">
        Overview of your store performance
    </p>

</div>






<!-- Statistics Cards -->

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">





<!-- Products -->

<div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">


<div class="flex justify-between items-center">


<div>

<p class="text-gray-500">
Products
</p>


<h2 class="text-3xl font-bold mt-2">

{{ $productsCount }}

</h2>


</div>



<div class="bg-blue-100 text-blue-600 w-14 h-14 rounded-full flex items-center justify-center">


<i class="fa-solid fa-box text-2xl"></i>


</div>



</div>


</div>







<!-- Active Products -->

<div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">


<div class="flex justify-between items-center">


<div>

<p class="text-gray-500">
Active Products
</p>


<h2 class="text-3xl font-bold mt-2">

{{ $activeProducts }}

</h2>


</div>



<div class="bg-green-100 text-green-600 w-14 h-14 rounded-full flex items-center justify-center">


<i class="fa-solid fa-circle-check text-2xl"></i>


</div>



</div>


</div>







<!-- Stock Value -->

<div class="bg-white rounded-xl shadow p-6 border-l-4 border-purple-500">


<div class="flex justify-between items-center">


<div>

<p class="text-gray-500">
Stock Value
</p>


<h2 class="text-3xl font-bold mt-2">

${{ number_format($stockValue,2) }}

</h2>


</div>



<div class="bg-purple-100 text-purple-600 w-14 h-14 rounded-full flex items-center justify-center">


<i class="fa-solid fa-dollar-sign text-2xl"></i>


</div>



</div>


</div>







<!-- Orders Placeholder -->

<div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">


<div class="flex justify-between">


<div>

<p class="text-gray-500">
Orders
</p>


<h2 class="text-3xl font-bold mt-2">

0

</h2>


</div>



<div class="bg-yellow-100 text-yellow-600 w-14 h-14 rounded-full flex items-center justify-center">


<i class="fa-solid fa-cart-shopping text-2xl"></i>


</div>



</div>


</div>






</div>









<!-- Main Sections -->


<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mt-6">






<!-- Sales Chart -->


<div class="xl:col-span-2 bg-white rounded-xl shadow p-6">


<div class="flex justify-between mb-6">


<h2 class="text-xl font-bold">

Sales Overview

</h2>



<select class="border rounded-lg px-3 py-2">


<option>
This Year
</option>


<option>
This Month
</option>


</select>



</div>





<div class="h-64 flex items-center justify-center text-gray-400">


Sales Chart Will Be Added Here


</div>



</div>







<!-- Activity -->


<div class="bg-white rounded-xl shadow p-6">


<h2 class="text-xl font-bold mb-5">

Recent Activity

</h2>




<div class="flex gap-3">


<div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">


<i class="fa-solid fa-user"></i>


</div>




<div>


<p class="font-medium">

Admin logged in

</p>


<span class="text-sm text-gray-400">

Just now

</span>


</div>


</div>



</div>






</div>









<!-- Latest Products -->


<div class="bg-white rounded-xl shadow p-6 mt-6">


<h2 class="text-xl font-bold mb-5">

Latest Products

</h2>





<div class="space-y-4">



@forelse($latestProducts as $product)



<div class="flex justify-between items-center border-b pb-4">



<div class="flex items-center gap-4">



@if($product->image)


<img src="{{ asset('storage/'.$product->image) }}"
class="w-14 h-14 rounded-lg object-cover border">


@else


<div class="w-14 h-14 rounded-lg bg-gray-100 flex items-center justify-center">


<i class="fa-solid fa-image text-gray-400"></i>


</div>


@endif





<div>


<h3 class="font-semibold">

{{ $product->name }}

</h3>


<p class="text-sm text-gray-500">

SKU: {{ $product->sku }}

</p>


</div>



</div>





<div class="font-bold">

${{ $product->price }}

</div>



</div>



@empty


<p class="text-gray-500">

No products found

</p>


@endforelse




</div>



</div>







@endsection