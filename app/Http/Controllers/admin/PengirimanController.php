<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::where('status', 'kirim')->get();;
        return view('admin.pengiriman.index', compact('transaksis'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::find($id);
        return view('admin.pengiriman.edit', compact('transaksi'));
    }

    public function edit(Request $request, $id)
    {

        $transaksi = Transaksi::find($id);

        if ($transaksi->transaksi_data->metode_pengiriman == 'jnt') {
            $request->validate([
                'resi' => 'required|max:255'
            ]);
        }
        $transaksi->transaksi_data()->update([
            'resi' => $request->resi,
            'shiping_time' => now()
        ]);
        return redirect()->back()->with('success', 'Transaksi berhasil diubah');
    }
}