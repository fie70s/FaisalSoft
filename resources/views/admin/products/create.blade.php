@extends('admin.layouts.app')


@section('content')


<div class="mb-6">

    <h1 class="text-3xl font-bold text-gray-800">
        Add Product
    </h1>

    <p class="text-gray-500">
        Create a new product
    </p>

</div>





<div class="bg-white rounded-xl shadow p-6"
x-data="{
    imagePreview:null,

    preview(event){

        let file = event.target.files[0];

        if(file){

            this.imagePreview = URL.createObjectURL(file);

        }

    }
}">



<form action="{{ route('admin.products.store') }}"
method="POST"
enctype="multipart/form-data">


@csrf



<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">



<div class="lg:col-span-2 space-y-5">


<div>

<label class="font-semibold">
Product Name
</label>

<input name="name"
class="w-full border rounded-lg p-3 mt-2">

</div>



<div class="grid grid-cols-2 gap-5">


<div>

<label class="font-semibold">
SKU
</label>

<input name="sku"
class="w-full border rounded-lg p-3 mt-2">

</div>



<div>

<label class="font-semibold">
Price
</label>

<input name="price"
type="number"
class="w-full border rounded-lg p-3 mt-2">

</div>


</div>




<div class="grid grid-cols-2 gap-5">


<div>

<label class="font-semibold">
Quantity
</label>

<input name="quantity"
type="number"
class="w-full border rounded-lg p-3 mt-2">

</div>



<div>

<label class="font-semibold">
Status
</label>


<select name="status"
class="w-full border rounded-lg p-3 mt-2">

<option value="active">
Active
</option>

<option value="inactive">
Inactive
</option>

</select>


</div>


</div>





<textarea name="description"
rows="5"
class="w-full border rounded-lg p-3"
placeholder="Description"></textarea>



</div>






<div>


<label class="font-semibold">
Product Image
</label>



<div class="mt-3 border-2 border-dashed rounded-xl p-5 text-center">





<template x-if="imagePreview">

<img :src="imagePreview"
class="w-48 h-48 mx-auto rounded-xl object-cover mb-4">

</template>



<template x-if="!imagePreview">

<div class="w-48 h-48 mx-auto bg-gray-100 rounded-xl flex items-center justify-center">

<i class="fa-solid fa-image text-5xl text-gray-400"></i>

</div>

</template>





<input
type="file"
name="image"
accept="image/*"
@change="preview"
class="mt-5 w-full border rounded-lg p-3">



</div>


</div>



</div>





<button
class="mt-8 bg-blue-600 text-white px-6 py-3 rounded-lg">

Save Product

</button>




</form>


</div>



@endsection