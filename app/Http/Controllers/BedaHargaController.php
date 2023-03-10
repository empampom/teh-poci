<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BedaHargaController extends Controller
{
    public function index()
    {
        $list_beda_harga = DB::table('beda_harga')
            ->join('cabang', 'beda_harga.cabang_id', '=', 'cabang.id')
            ->join('menu', 'beda_harga.menu_id', '=', 'menu.id')
            ->select('beda_harga.id', 'cabang.nama AS nama_cabang', 'menu.nama AS nama_menu', 'beda_harga.harga AS harga_beda')
            ->whereNull('beda_harga.deleted_at')
            ->whereNull('cabang.deleted_at')
            ->whereNull('menu.deleted_at')
            ->orderBy('cabang.id')
            ->orderBy('beda_harga.harga')
            ->get();
        $list_cabang = DB::table('cabang')->whereNull('deleted_at')->orderBy('id')->get();
        $list_menu = DB::table('menu')->whereNull('deleted_at')->orderBy('harga')->get();

        return view('beda_harga', compact('list_beda_harga', 'list_cabang', 'list_menu'));
    }

    public function store(Request $request)
    {
        $cabang_id = $request->cabang_id;
        $menu_id = $request->menu_id;
        $harga = $request->harga;

        DB::table('beda_harga')->insert([
            'created_at' => now(),
            'created_by' => auth()->user()->id,
            'cabang_id' => $cabang_id,
            'menu_id' => $menu_id,
            'harga' => $harga
        ]);

        return redirect()->route('beda_harga.index')->with('status', ['success', 'Data Berhasil di Tambahkan']);
    }

    public function edit(Request $request)
    {
        $beda_harga_id = $request->beda_harga_id;

        $beda_harga = DB::table('beda_harga')->where('id', $beda_harga_id)->first();

        return $beda_harga;
    }

    public function update(Request $request)
    {
        $beda_harga_id = $request->beda_harga_id;
        $cabang_id = $request->cabang_id;
        $menu_id = $request->menu_id;
        $harga = $request->harga;

        DB::table('beda_harga')
            ->where('id', $beda_harga_id)
            ->update([
                'updated_at' => now(),
                'updated_by' => auth()->user()->id,
                'cabang_id' => $cabang_id,
                'menu_id' => $menu_id,
                'harga' => $harga
            ]);

        return redirect()->route('beda_harga.index')->with('status', ['success', 'Data Berhasil di Ubah']);
    }

    public function destroy(Request $request)
    {
        $beda_harga_id = $request->beda_harga_id;

        DB::table('beda_harga')
            ->where('id', $beda_harga_id)
            ->update([
                'deleted_at' => now(),
                'deleted_by' => auth()->user()->id
            ]);

        return redirect()->route('beda_harga.index')->with('status', ['success', 'Data Berhasil di Hapus']);
    }
}
