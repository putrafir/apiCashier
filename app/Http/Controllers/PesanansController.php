<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePesanansRequest;
use App\Http\Requests\UpdatePesanansRequest;
use App\Models\Keranjangs;
use App\Models\Pesanans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function PHPSTORM_META\map;

class PesanansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanans = Pesanans::all();
        return response()->json(
            $pesanans->map(function ($pesanan) {
                return [
                    'id' => $pesanan->id,
                    'total_bayar' => $pesanan->total_bayar,
                    'menus' => $pesanan->menus
                ];
            })
        );
    }


    public function store(Request $request)
    {
        // Log::info('Request Data:', $request->all());

        try {
            Log::channel('custom_log')->info('Memulai proses pembuatan pesanan', ['request_data' => $request->all()]);
            $validatedData = $request->validate([
                'keranjang_ids' => 'required|array',
                'keranjang_ids.*' => 'exists:keranjangs,id',
                'total_bayar' => 'required|numeric|min:0',
            ]);

            Log::channel('custom_log')->info('Validasi berhasil', ['validated_data' => $validatedData]);

            $keranjangs = Keranjangs::with('products.categories')->whereIn('id', $validatedData['keranjang_ids'])->get();

            Log::info('Data keranjang berhasil diambil', ['keranjangs' => $keranjangs]);

            $pesanan = Pesanans::create([
                'total_bayar' => $validatedData['total_bayar'],
                'menus' => json_encode($keranjangs->map(function ($keranjang) {
                    return [
                        'jumlah' => $keranjang->jumlah,
                        'total_harga' => $keranjang->total_harga,
                        'product' => $keranjang->products->only(['id', 'kode', 'nama', 'harga', 'is_ready', 'gambar']),
                        'category' => $keranjang->products->categories->only(['id', 'nama']),
                    ];
                })->toArray())
            ]);

            Log::channel('custom_log')->info('Pesanan berhasil dibuat', ['pesanan_id' => $pesanan->id]);




            Log::channel('custom_log')->info('Keranjang berhasil disinkronkan', ['pesanan_id' => $pesanan->id]);

            return response()->json([
                'id' => $pesanan->id,
                'total_bayar' => $pesanan->total_bayar,
                'menus' => $pesanan->menus
            ], 201);
        } catch (\Throwable $e) {
            Log::channel('custom_log')->error('Terjadi kesalahan saat membuat pesanan', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Kembalikan respons error
            return response()->json([
                'error' => 'Terjadi kesalahan saat memproses pesanan.',
                'message' => $e->getMessage(),
            ], 500);
        }
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

    public function deleteAllKeranjangs()
    {
        // Menghapus semua data di tabel keranjangs
        Keranjangs::truncate();

        return response()->json([
            'message' => 'Semua data di keranjangs telah dihapus.'
        ], 200);
    }
}
