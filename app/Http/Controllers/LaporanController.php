<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
// ini perubahan

class LaporanController extends Controller
{
    public function index()
    {
        $cabang_akses = explode(",", auth()->user()->cabang);
        if ($cabang_akses[0] == 'all') {
            $list_cabang = DB::table('cabang')->whereNull('deleted_at')->orderBy('id')->get();
        } else {
            $list_cabang = DB::table('cabang')->whereIn('id', $cabang_akses)->whereNull('deleted_at')->orderBy('id')->get();
        }

        return view('laporan', compact('list_cabang'));
    }

    public function result(Request $request)
    {
        $jenis = $request->jenis;
        $cabang_id = $request->cabang_id;
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;

        if ($cabang_id == 'all') {
            $tambahan_cabang = "";
        } else {
            $tambahan_cabang = "AND transaksi.cabang_id = $cabang_id";
        }

        $start = Carbon::createFromFormat('Y-m-d', $tgl_awal)->startOfDay()->format('Y-m-d H:i:s');
        $end = Carbon::createFromFormat('Y-m-d', $tgl_akhir)->endOfDay()->format('Y-m-d H:i:s');

        if ($jenis == 'penjualan') {
            $query =   "SELECT
                            cabang.nama AS nama_cabang,
                            transaksi.id,
                            transaksi.tgl_jam,
                            transaksi.kode,
                            transaksi.tagihan,
                            transaksi.diskon
                        FROM
                            transaksi
                        JOIN cabang ON
                            transaksi.cabang_id = cabang.id
                        WHERE
                            transaksi.tgl_jam BETWEEN '$start' AND '$end'
                            $tambahan_cabang
                        ORDER BY
                            nama_cabang,
                            kode";
            $list_penjualan = DB::select($query);

            $query =   "SELECT
                            transaksi.id,
                            menu.nama AS nama_menu,
                            transaksi_detail.jumlah,
                            transaksi_detail.harga,
                            transaksi_detail.total
                        FROM
                            transaksi
                        JOIN cabang ON
                            transaksi.cabang_id = cabang.id
                        JOIN transaksi_detail ON
                            transaksi.id = transaksi_detail.transaksi_id
                        JOIN menu ON
                            transaksi_detail.menu_id = menu.id
                        WHERE
                            transaksi.tgl_jam BETWEEN '$start' AND '$end'
                            $tambahan_cabang";
            $list_penjualan_detail = DB::select($query);

            return view('laporan/penjualan', compact('list_penjualan', 'list_penjualan_detail', 'tgl_awal', 'tgl_akhir'));
        }

        if ($jenis == 'pembayaran') {
            $query =   "SELECT
                            cabang.nama AS nama_cabang,
                            pembayaran.nama AS nama_bayar,
                            sum(transaksi.tagihan) - sum(transaksi.diskon) AS total_bayar
                        FROM
                            transaksi
                        JOIN cabang ON
                            transaksi.cabang_id = cabang.id
                        JOIN transaksi_bayar ON
                            transaksi.id = transaksi_bayar.transaksi_id
                        JOIN pembayaran ON
                            transaksi_bayar.pembayaran_id = pembayaran.id
                        WHERE
                            transaksi.tgl_jam BETWEEN '$start' AND '$end'
                            $tambahan_cabang
                        GROUP BY
                            nama_cabang,
                            nama_bayar
                        ORDER BY
                            nama_cabang,
                            total_bayar DESC";
            $list_pembayaran = DB::select($query);

            return view('laporan/pembayaran', compact('list_pembayaran', 'tgl_awal', 'tgl_akhir'));
        }

        if ($jenis == 'terlaris') {
            $query =   "SELECT
                            cabang.nama AS nama_cabang,
                            menu.nama AS nama_menu,
                            sum(transaksi_detail.jumlah) AS jumlah_pesan,
                            sum(transaksi_detail.total) AS total_pesan
                        FROM
                            transaksi
                        JOIN cabang ON
                            transaksi.cabang_id = cabang.id
                        JOIN transaksi_detail ON
                            transaksi.id = transaksi_detail.transaksi_id
                        JOIN menu ON
                            transaksi_detail.menu_id = menu.id
                        WHERE
                            transaksi.tgl_jam BETWEEN '$start' AND '$end'
                            $tambahan_cabang
                        GROUP BY
                            nama_cabang,
                            nama_menu
                        ORDER BY
                            nama_cabang,
                            jumlah_pesan DESC,
                            total_pesan DESC";
            $list_terlaris = DB::select($query);

            return view('laporan/terlaris', compact('list_terlaris', 'tgl_awal', 'tgl_akhir'));
        }
    }
}
