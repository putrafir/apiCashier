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
        $query = Products::with('categories');

        if ($request->has('categories.nama')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('nama', $request->input('categories.nama'));
            });
        }

        return $query->get();
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
