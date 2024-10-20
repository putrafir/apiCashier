<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function index(Request $request)
    {
        // $categoryName = $request->query('categories.nama');

        // $product = Products::with('categories')->when($categoryName, function ($query, $categoryName) {
        //     $query->whereHas('categories', function ($query) use ($categoryName) {
        //         $query->where('nama', 'like', '%' . $categoryName . '%');
        //     });
        // })->get();


        $categories = $request->input('categories');
        $product = Products::with('categories')->whereHas('categories', function ($query) use ($categories) {
            $query->where('nama', 'like', '%' . $categories . '%');
        })->get();

        return response()->json($product);
    }

    public function store(Request $request)
    {
        $product = Products::create($request->all());
        return response()->json($product, 201);
    }

    public function show($id)
    {
        return Products::with('categories')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);
        $product->update($request->all());
        return response()->json($product, 200);
    }

    public function destroy($id)
    {
        Products::destroy($id);
        return response()->json(null, 204);
    }
}
