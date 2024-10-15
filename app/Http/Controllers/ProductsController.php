<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function index()
    {
        return Products::with('category')->get();
    }

    public function store(Request $request)
    {
        $product = Products::create($request->all());
        return response()->json($product, 201);
    }

    public function show($id)
    {
        return Products::with('category')->findOrFail($id);
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
