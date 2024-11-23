<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePesanansRequest;
use App\Http\Requests\UpdatePesanansRequest;
use App\Models\Pesanans;
use Illuminate\Http\Request;

class PesanansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return Pesanans::with('keranjangs.products')->get();

        $keranjangId = $request->query('keranjang_id');

        $pesanans = Pesanans::with('keranjangs.products.categories')->when($keranjangId, function ($query, $keranjangId) {
            return $query->where('keranjang_id', $keranjangId);
        })->get();

        return response()->json(
            $pesanans->map(function ($pesanan) {
                return [
                    'id' => $pesanan->id,
                    'total_bayar' => $pesanan->total_bayar,
                    'menus' => $pesanan->keranjangs->map(function ($keranjang) {
                        return [
                            'jumlah' => $keranjang->jumlah,
                            'total_harga' => $keranjang->total_harga,
                            'product' => $keranjang->products->only(['id', 'kode', 'nama', 'harga', 'is_ready', 'gambar']) + [
                                'category' => $keranjang->products->categories->only(['id', 'nama'])
                            ],
                        ];
                    })
                    // 'menu' => $pesanan->keranjangs->only(['jumlah', 'total_harga']) + [
                    //     'product' => $pesanan->keranjangs->products->only(['id', 'kode', 'nama', 'harga', 'is_ready', 'gambar'])
                    // ]
                ];
            })
        );
    }


    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'menus.*.id' => 'required|exists:keranjangs,id',
            'total_bayar' => 'required|numeric|min:0',
        ]);
    
        $pesananList = [];
        foreach ($validatedData['menus'] as $menu) {
            $pesananList[] = Pesanans::create([
                'keranjang_id' => $menu['id'],
                'total_bayar' => $validatedData['total_bayar'], // Bisa disesuaikan untuk setiap menu
            ]);
        }
    
        return response()->json([
            'pesanan_ids' => array_column($pesananList, 'id'),
            'total_bayar' => $validatedData['total_bayar'],
        ], 201);
    }

    public function show($id)
    {
        $pesanan = Pesanans::with('keranjangs.products.categories')->findOrFail($id);

        return response()->json(
            $pesanan
            // [
            //     'total_bayar' => $pesanan->total_bayar,
            //     'menus' => $pesanan->keranjangs->map(fn($item) => [
            //         'jumlah' => $item->jumlah,
            //         'total_harga' => $item->total_harga,
            //         'product' => $item->products->only(['id', 'kode', 'nama', 'harga', 'is_ready', 'gambar']) + [
            //             'category' => $item->products->categories->only(['id', 'nama']),
            //         ],
            //     ]),
            // ]
        );
    }

    public function update(Request $request, $id)
    {
        $pesanan = Pesanans::findOrFail($id);
        $pesanan->update($request->all());
        return response()->json($pesanan, 200);
    }

    public function destroy($id)
    {
        Pesanans::destroy($id);
        return response()->json(null, 204);
    }
}
