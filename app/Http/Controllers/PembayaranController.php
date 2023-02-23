<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index()
    {
        $list_pembayaran = DB::table('pembayaran')->whereNull('deleted_at')->get();

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

    public function edit(Request $request)
    {
        $pembayaran_id = $request->pembayaran_id;

        $pembayaran = DB::table('pembayaran')->where('id', $pembayaran_id)->first();

        return $pembayaran;
    }

    public function update(Request $request)
    {
        $pembayaran_id = $request->pembayaran_id;
        $nama = $request->nama;

        DB::table('pembayaran')
            ->where('id', $pembayaran_id)
            ->update([
                'updated_at' => now(),
                'updated_by' => auth()->user()->id,
                'nama' => $nama
            ]);

        return redirect()->route('pembayaran.index')->with('status', ['success', 'Data Berhasil di Ubah']);
    }

    public function destroy(Request $request)
    {
        $pembayaran_id = $request->pembayaran_id;

        DB::table('pembayaran')
            ->where('id', $pembayaran_id)
            ->update([
                'deleted_at' => now(),
                'deleted_by' => auth()->user()->id
            ]);

        return redirect()->route('pembayaran.index')->with('status', ['success', 'Data Berhasil di Hapus']);
    }
}
