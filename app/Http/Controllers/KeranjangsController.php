<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKeranjangsRequest;
use App\Http\Requests\UpdateKeranjangsRequest;
use App\Models\Keranjangs;
use Illuminate\Http\Request;

class KeranjangsController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    //    public function store(Request $request)
    // {
    //     $keranjang = Keranjangs::create([
    //         'product_id' => $request->input('product.id'),
    //         'jumlah' => $request->input('jumlah'),
    //         'total_harga' => $request->input('total_harga'),
    //     ]);

    //     return response()->json([
    //         'id' => $keranjang->id,
    //         'jumlah' => $keranjang->jumlah,
    //         'total_harga' => $keranjang->total_harga,
    //         'product' => $request->input('product'), // Jika ingin tetap mengembalikan data produk
    //     ], 200);
    // }


    // public function indesx(Request $request)
    // {

    //     $productId = $request->query('product_id');

    //     $keranjangs = Keranjangs::with('products.categories')
    //         ->when($productId, function ($query, $productId) {
    //             return $query->whereHas('products', function ($q) use ($productId) {
    //                 $q->where('id', $productId);
    //             });
    //         })
    //         ->get();

    //     return response()->json(
    //         $keranjangs->map(function ($keranjang) {
    //             return [
    //                 'id' => $keranjang->id,
    //                 'jumlah' => $keranjang->jumlah,
    //                 'total_harga' => $keranjang->total_harga,
    //                 'product' => $keranjang->products->only(['id', 'kode', 'nama', 'harga', 'is_ready', 'gambar']) + [
    //                     'category' => $keranjang->products->categories->only(['id', 'nama']),
    //                 ],
    //             ];
    //         })

    //     );
    // }




    public function index(Request $request)
    {
        $productId = $request->query('product_id');

        $keranjangs = Keranjangs::with('products.categories')
            ->when($productId, function ($query, $productId) {
                return $query->where('product_id', $productId);
            })
            ->get();

        return response()->json(
            $keranjangs->map(function ($keranjang) {
                return [
                    'id' => $keranjang->id,
                    'jumlah' => $keranjang->jumlah,
                    'total_harga' => $keranjang->total_harga,
                    'product' => $keranjang->products->only(['id', 'kode', 'nama', 'harga', 'is_ready', 'gambar']) + [
                        'category' => $keranjang->products->categories->only(['id', 'nama']),
                    ],
                ];
            })
        );
    }




    public function store(Request $request)
    {
        $keranjang = Keranjangs::create([
            'product_id' => $request->input('product.id'),
            'jumlah' => $request->input('jumlah'),
            'total_harga' => $request->input('total_harga'),
        ]);

        return response()->json([
            'id' => $keranjang->id,
            'jumlah' => $keranjang->jumlah,
            'total_harga' => $keranjang->total_harga,
            'product' => $request->input('product'), // Jika ingin tetap mengembalikan data produk
        ], 200);
    }

    public function show($id)
    {
        $keranjang = Keranjangs::with('products.categories')->find($id);
        return response()->json([
            'jumlah' => $keranjang->jumlah,
            'total_harga' => $keranjang->total_harga,
            'product' => $keranjang->products->toArray(),
            'id' => $keranjang->id
        ]);
    }

    public function update(Request $request, $id)
    {
        $keranjang = Keranjangs::findOrFail($id);
        $keranjang->jumlah = $request->input('jumlah', $keranjang->jumlah);
        $keranjang->total_harga = $request->input('total_harga', $keranjang->total_harga);

        $keranjang->save();

        return response()->json($keranjang, 200);
    }

    public function destroy($id)
    {
        Keranjangs::destroy($id);
        return response()->json(null, 204);
    }
}
