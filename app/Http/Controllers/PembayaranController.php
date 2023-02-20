<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index()
    {
        $list_pembayaran = DB::table('pembayaran')->get();

        return view('pembayaran', compact('list_pembayaran'));
    }

    public function store(Request $request)
    {
        $nama = $request->nama;

        DB::table('pembayaran')->insert([
            'created_at' => now(),
            'created_by' => auth()->user()->id,
            'nama' => $nama,
        ]);

        return redirect()->route('pembayaran.index')->with('status', ['success', 'Data Berhasil di Tambahkan']);
    }
}
