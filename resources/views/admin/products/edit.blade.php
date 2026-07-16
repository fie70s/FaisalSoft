@extends('admin.layouts.app')


@section('content')


<div class="mb-6">

    <h1 class="text-3xl font-bold text-gray-800">
        Edit Product
    </h1>

    <p class="text-gray-500">
        Update product information
    </p>

</div>





@if($errors->any())

<div class="bg-red-100 text-red-700 p-4 rounded-lg mb-5">

    <ul>

        @foreach($errors->all() as $error)

        <li>
            {{ $error }}
        </li>

        @endforeach

    </ul>

</div>

@endif






<div class="bg-white rounded-xl shadow p-6"
x-data="{

    imagePreview: '{{ $product->image ? asset('storage/'.$product->image) : '' }}',

    preview(event){

        let file = event.target.files[0];

        if(file){

            this.imagePreview = URL.createObjectURL(file);

        }

    }

}">





<form action="{{ route('admin.products.update',$product) }}"
      method="POST"
      enctype="multipart/form-data">


@csrf

@method('PUT')





<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">





<!-- Product Information -->

<div class="lg:col-span-2 space-y-6">





<div>

<label class="block mb-2 font-semibold text-gray-700">

Product Name

</label>


<input type="text"
name="name"
value="{{ old('name',$product->name) }}"
class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-200">


</div>







<div class="grid grid-cols-1 md:grid-cols-2 gap-6">


<div>

<label class="block mb-2 font-semibold text-gray-700">

SKU

</label>


<input type="text"
name="sku"
value="{{ old('sku',$product->sku) }}"
class="w-full border rounded-lg p-3">


</div>





<div>

<label class="block mb-2 font-semibold text-gray-700">

Price

</label>


<input type="number"
step="0.01"
name="price"
value="{{ old('price',$product->price) }}"
class="w-full border rounded-lg p-3">


</div>


</div>








<div class="grid grid-cols-1 md:grid-cols-2 gap-6">



<div>

<label class="block mb-2 font-semibold text-gray-700">

Quantity

</label>


<input type="number"
name="quantity"
value="{{ old('quantity',$product->quantity) }}"
class="w-full border rounded-lg p-3">


</div>






<div>

<label class="block mb-2 font-semibold text-gray-700">

Status

</label>


<select name="status"
class="w-full border rounded-lg p-3">


<option value="active"
@if($product->status == 'active') selected @endif>

Active

</option>



<option value="inactive"
@if($product->status == 'inactive') selected @endif>

Inactive

</option>


</select>


</div>


</div>







<div>

<label class="block mb-2 font-semibold text-gray-700">

Description

</label>


<textarea
name="description"
rows="5"
class="w-full border rounded-lg p-3">{{ old('description',$product->description) }}</textarea>


</div>






</div>









<!-- Image Section -->

<div>


<label class="block mb-2 font-semibold text-gray-700">

Product Image

</label>





<div class="border-2 border-dashed rounded-xl p-5 text-center">





<template x-if="imagePreview">


<img :src="imagePreview"
class="w-48 h-48 mx-auto rounded-xl object-cover border mb-4">


</template>





<template x-if="!imagePreview">


<div class="w-48 h-48 mx-auto rounded-xl bg-gray-100 flex items-center justify-center mb-4">


<i class="fa-solid fa-image text-5xl text-gray-400"></i>


</div>


</template>







<input type="file"
name="image"
accept="image/*"
id="imageInput"
@change="preview"
class="hidden">





<label for="imageInput"
class="cursor-pointer bg-blue-600 text-white px-5 py-3 rounded-lg inline-block">


<i class="fa-solid fa-upload"></i>

Change Image


</label>






<p class="text-sm text-gray-500 mt-3">

JPG, PNG, WEBP - Max 2MB

</p>





</div>


</div>






</div>








<div class="mt-8 flex gap-3">


<button
class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">


Update Product


</button>





<a href="{{ route('admin.products.index') }}"
class="bg-gray-200 px-6 py-3 rounded-lg">


Cancel


</a>



</div>






</form>


</div>




@endsection