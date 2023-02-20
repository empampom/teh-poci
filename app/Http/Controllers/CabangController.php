<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CabangController extends Controller
{
    public function index()
    {
        $list_cabang = DB::table('cabang')->get();

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
}
