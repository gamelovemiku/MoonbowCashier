<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all()->take(15);
        return response()->json($product);
    }

    public function newproduct(Request $request)
    {
        $product = new Product;

        $product->product_barcode = $request->barcode;
        $product->product_name = $request->name;
        $product->product_price = $request->price;
        $product->product_sold = 0;
        $product->save();
    }

    public function show($id)
    {
        $product = Product::where('product_barcode', $id)->get()->take(1);
        return response()->json($product[0]);
    }

    public function updateproduct(Request $request)
    {

        Product::where('product_barcode', $request->barcode)->update([
            'product_barcode' => $request->barcode,
            'product_name' => $request->name,
            'product_price' => $request->price,
        ]);
    }
}
