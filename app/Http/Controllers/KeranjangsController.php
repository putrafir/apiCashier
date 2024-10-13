<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKeranjangsRequest;
use App\Http\Requests\UpdateKeranjangsRequest;
use App\Models\Keranjangs;

class KeranjangsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Keranjangs::with('product')->get();
    }

    public function store(StoreKeranjangsRequest $request)
    {
        $keranjang = Keranjangs::create($request->all());
        return response()->json($keranjang, 201);
    }

    public function show($id)
    {
        return Keranjangs::with('product')->findOrFail($id);
    }

    public function update(UpdateKeranjangsRequest $request, $id)
    {
        $keranjang = Keranjangs::findOrFail($id);
        $keranjang->update($request->all());
        return response()->json($keranjang, 200);
    }

    public function destroy($id)
    {
        Keranjangs::destroy($id);
        return response()->json(null, 204);
    }
}
