<?php
// ini halaman menu yaa

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $list_menu = DB::table('menu')->whereNull('deleted_at')->orderBy('harga')->get();

        return view('menu', compact('list_menu'));
    }

    public function store(Request $request)
    {
        $nama = $request->nama;
        $harga = $request->harga;

        $file = $request->file('gambar');
        $nama_gambar = $file->getClientOriginalName();
        $ekstensi = Str::afterLast($nama_gambar, '.');
        $destinasi = public_path() . '/gambar_menu';

        $id = DB::table('menu')->insertGetId([
            'created_at' => now(),
            'created_by' => auth()->user()->id,
            'nama' => $nama,
            'harga' => $harga
        ]);

        $nama_baru = $id . '.' . $ekstensi;
        $file->move($destinasi, $nama_baru);

        DB::table('menu')
            ->where('id', $id)
            ->update(['gambar' => $nama_baru]);

        return redirect()->route('menu.index')->with('status', ['success', 'Data Berhasil di Tambahkan']);
    }

    public function edit(Request $request)
    {
        $menu_id = $request->menu_id;

        $menu = DB::table('menu')->where('id', $menu_id)->first();

        return $menu;
    }

    public function update(Request $request)
    {
        $menu_id = $request->menu_id;
        $nama = $request->nama;
        $harga = $request->harga;

        $file = $request->file('gambar');
        if (!empty($file)) {
            $nama_gambar = $file->getClientOriginalName();
            $ekstensi = Str::lower(Str::afterLast($nama_gambar, '.'));
            $nama_baru = $menu_id . '.' . $ekstensi;
            if (file_exists($nama_baru)) {
                unlink($nama_baru);
            }
            $destinasi = public_path() . '/gambar_menu';
            $file->move($destinasi, $nama_baru);

            DB::table('menu')
                ->where('id', $menu_id)
                ->update([
                    'gambar' => $nama_baru
                ]);
        }

        DB::table('menu')
            ->where('id', $menu_id)
            ->update([
                'updated_at' => now(),
                'updated_by' => auth()->user()->id,
                'nama' => $nama,
                'harga' => $harga
            ]);

        return redirect()->route('menu.index')->with('status', ['success', 'Data Berhasil di Ubah']);
    }

    public function destroy(Request $request)
    {
        $menu_id = $request->menu_id;

        DB::table('menu')
            ->where('id', $menu_id)
            ->update([
                'deleted_at' => now(),
                'deleted_by' => auth()->user()->id
            ]);

        return redirect()->route('menu.index')->with('status', ['success', 'Data Berhasil di Hapus']);
    }
}
