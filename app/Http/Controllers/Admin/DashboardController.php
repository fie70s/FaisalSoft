<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Product;


class DashboardController extends Controller
{


    public function index()
    {


        // Total Products
        $productsCount = Product::count();



        // Active Products
        $activeProducts = Product::where('status','active')->count();



        // Total Stock Value
        $stockValue = Product::sum(\DB::raw('price * quantity'));



        // Latest Products
        $latestProducts = Product::latest()
            ->take(5)
            ->get();





        return view('admin.dashboard', compact(

            'productsCount',

            'activeProducts',

            'stockValue',

            'latestProducts'

        ));



    }


}