<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CabangController extends Controller
{
    public function index()
    {
        $list_cabang = DB::table('cabang')->whereNull('deleted_at')->get();

        return view('cabang', compact('list_cabang'));
    }

    public function store(Request $request)
    {
        $nama = $request->nama;
        $lokasi = $request->lokasi;
        $alamat = $request->alamat;
        $telpon = $request->telpon;
        $kode = $request->kode;

        DB::table('cabang')->insert([
            'created_at' => now(),
            'created_by' => auth()->user()->id,
            'nama' => $nama,
            'lokasi' => $lokasi,
            'alamat' => $alamat,
            'telpon' => $telpon,
            'kode' => $kode
        ]);

        return redirect()->route('cabang.index')->with('status', ['success', 'Data Berhasil di Tambahkan']);
    }

    public function edit(Request $request)
    {
        $cabang_id = $request->cabang_id;

        $cabang = DB::table('cabang')->where('id', $cabang_id)->first();

        return $cabang;
    }

    public function update(Request $request)
    {
        $cabang_id = $request->cabang_id;
        $nama = $request->nama;
        $lokasi = $request->lokasi;
        $alamat = $request->alamat;
        $telpon = $request->telpon;
        $kode = $request->kode;

        DB::table('cabang')
            ->where('id', $cabang_id)
            ->update([
                'updated_at' => now(),
                'updated_by' => auth()->user()->id,
                'nama' => $nama,
                'lokasi' => $lokasi,
                'alamat' => $alamat,
                'telpon' => $telpon,
                'kode' => $kode
            ]);

        return redirect()->route('cabang.index')->with('status', ['success', 'Data Berhasil di Ubah']);
    }

    public function destroy(Request $request)
    {
        $cabang_id = $request->cabang_id;

        DB::table('cabang')
            ->where('id', $cabang_id)
            ->update([
                'deleted_at' => now(),
                'deleted_by' => auth()->user()->id
            ]);

        return redirect()->route('cabang.index')->with('status', ['success', 'Data Berhasil di Hapus']);
    }
}
