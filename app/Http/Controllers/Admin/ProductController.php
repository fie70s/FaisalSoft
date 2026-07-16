<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{


    public function index(Request $request)
    {

        $query = Product::query();



        // Search
        if($request->filled('search')){

            $search = $request->search;


            $query->where(function($q) use ($search){

                $q->where('name','like','%'.$search.'%')
                  ->orWhere('sku','like','%'.$search.'%');

            });

        }




        // Filter Status
        if($request->filled('status')){

            $query->where('status',$request->status);

        }





        $products = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();




        return view('admin.products.index',compact('products'));

    }







    public function create()
    {

        return view('admin.products.create');

    }







    public function store(Request $request)
    {


        $data = $request->validate([


            'name'=>'required|string|max:255',

            'sku'=>'required|string|max:100|unique:products',

            'price'=>'required|numeric',

            'quantity'=>'required|integer',

            'status'=>'required',

            'description'=>'nullable|string',

            'image'=>'nullable|image|max:2048',


        ]);






        if($request->hasFile('image')){


            $data['image'] =
                $request->file('image')
                ->store('products','public');


        }





        Product::create($data);




        return redirect()
            ->route('admin.products.index')
            ->with('success','Product created successfully');



    }








    public function edit(Product $product)
    {

        return view('admin.products.edit',compact('product'));

    }








    public function update(Request $request, Product $product)
    {


        $data = $request->validate([


            'name'=>'required|string|max:255',

            'sku'=>'required|string|max:100|unique:products,sku,'.$product->id,

            'price'=>'required|numeric',

            'quantity'=>'required|integer',

            'status'=>'required',

            'description'=>'nullable|string',

            'image'=>'nullable|image|max:2048',


        ]);








        if($request->hasFile('image')){


            if($product->image){

                Storage::disk('public')
                    ->delete($product->image);

            }



            $data['image'] =
                $request->file('image')
                ->store('products','public');


        }







        $product->update($data);






        return redirect()
            ->route('admin.products.index')
            ->with('success','Product updated successfully');


    }








    public function destroy(Product $product)
    {


        if($product->image){

            Storage::disk('public')
                ->delete($product->image);

        }



        $product->delete();




        return redirect()
            ->route('admin.products.index')
            ->with('success','Product deleted successfully');


    }



}