@extends('admin.layouts.app')


@section('content')


<div class="mb-6 flex justify-between items-center">


<div>

<h1 class="text-3xl font-bold text-gray-800">
Products
</h1>


<p class="text-gray-500">
Manage your store products
</p>


</div>



<a href="{{ route('admin.products.create') }}"
class="bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700">


<i class="fa-solid fa-plus"></i>

Add Product


</a>



</div>






@if(session('success'))

<div class="bg-green-100 text-green-700 px-5 py-3 rounded-lg mb-5">

<i class="fa-solid fa-circle-check"></i>

{{ session('success') }}

</div>

@endif







<div class="bg-white rounded-xl shadow p-6 mb-6">


<form method="GET"
action="{{ route('admin.products.index') }}">


<div class="grid grid-cols-1 md:grid-cols-3 gap-4">





<div>

<label class="text-sm text-gray-600">

Search

</label>


<input type="text"
name="search"
value="{{ request('search') }}"
placeholder="Product name or SKU"

class="w-full border rounded-lg p-3 mt-1">


</div>







<div>

<label class="text-sm text-gray-600">

Status

</label>



<select name="status"
class="w-full border rounded-lg p-3 mt-1">


<option value="">
All Status
</option>



<option value="active"
@if(request('status')=='active') selected @endif>

Active

</option>



<option value="inactive"
@if(request('status')=='inactive') selected @endif>

Inactive

</option>


</select>


</div>







<div class="flex items-end gap-3">


<button
class="bg-gray-800 text-white px-5 py-3 rounded-lg">


<i class="fa-solid fa-search"></i>

Search


</button>



<a href="{{ route('admin.products.index') }}"
class="bg-gray-200 px-5 py-3 rounded-lg">


Reset


</a>



</div>




</div>


</form>


</div>









<div class="bg-white rounded-xl shadow overflow-hidden">



<div class="overflow-x-auto">


<table class="w-full text-left">



<thead class="bg-gray-100">


<tr>


<th class="p-4">
Image
</th>


<th class="p-4">
Product
</th>


<th class="p-4">
SKU
</th>


<th class="p-4">
Price
</th>


<th class="p-4">
Stock
</th>


<th class="p-4">
Status
</th>


<th class="p-4">
Actions
</th>


</tr>


</thead>






<tbody>



@forelse($products as $product)



<tr class="border-b hover:bg-gray-50">





<td class="p-4">


@if($product->image)


<img src="{{ asset('storage/'.$product->image) }}"
class="w-16 h-16 rounded-lg object-cover border">


@else


<div class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center">

<i class="fa-solid fa-image text-gray-400"></i>

</div>


@endif



</td>







<td class="p-4">


<div class="font-semibold">

{{ $product->name }}

</div>


<div class="text-sm text-gray-500">

{{ Str::limit($product->description,40) }}

</div>


</td>







<td class="p-4">

{{ $product->sku }}

</td>







<td class="p-4 font-semibold">

${{ number_format($product->price,2) }}

</td>








<td class="p-4">


@if($product->quantity <= 0)


<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">

Out

</span>


@elseif($product->quantity <= 5)


<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">

Low ({{ $product->quantity }})

</span>


@else


<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

{{ $product->quantity }}

</span>


@endif



</td>








<td class="p-4">


@if($product->status == 'active')


<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

Active

</span>


@else


<span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">

Inactive

</span>


@endif



</td>








<td class="p-4">



<a href="{{ route('admin.products.edit',$product) }}"
class="text-blue-600 mr-3">

<i class="fa-solid fa-pen"></i>

</a>






<form action="{{ route('admin.products.destroy',$product) }}"
method="POST"
class="inline"
onsubmit="return confirm('Delete this product?')">


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

<td colspan="7"
class="p-6 text-center text-gray-500">


No Products Found


</td>

</tr>



@endforelse




</tbody>



</table>



</div>


</div>






<div class="mt-6">

{{ $products->links() }}

</div>



@endsection