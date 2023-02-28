<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function home()
    {
        $cabang_akses = explode(",", auth()->user()->cabang);
        if ($cabang_akses[0] == 'all') {
            $list_cabang = DB::table('cabang')->whereNull('deleted_at')->orderBy('id')->get();
        } else {
            $list_cabang = DB::table('cabang')->whereIn('id', $cabang_akses)->whereNull('deleted_at')->orderBy('id')->get();
        }

        return view('index', compact('list_cabang'));
    }

    public function index($cabang_id)
    {
        $query   = "SELECT
                        menu.id,
                        menu.gambar,
                        menu.nama,
                        CASE
                            WHEN subquery.harga IS NOT NULL THEN subquery.harga
                            ELSE menu.harga
                        END AS harga,
                        menu.harga AS harga_asli,
                        subquery.harga AS harga_beda
                    FROM
                        menu
                    LEFT JOIN (
                        SELECT
                            menu_id,
                            harga
                        FROM
                            beda_harga
                        WHERE
                            cabang_id = $cabang_id
                            AND deleted_at IS NULL) subquery ON
                        menu.id = subquery.menu_id
                    WHERE
                        deleted_at IS NULL
                    ORDER BY
                        harga,
                        nama";
        $list_menu = DB::select(DB::raw($query));

        $list_pembayaran = DB::table('pembayaran')->whereNull('deleted_at')->get();

        return view('transaksi', compact('cabang_id', 'list_menu', 'list_pembayaran'));
    }

    public function store(Request $request, $cabang_id)
    {
        $pesanan = $request->pesanan;
        $pembayaran = $request->pembayaran;
        $diskon = Str::replace('.', '', $request->diskon);
        $diskon = $diskon == '' ? 0 : $diskon;

        $pecah_tanggal = Carbon::parse(now());
        $tahun = $pecah_tanggal->isoFormat('YYYY');
        $bulan = $pecah_tanggal->isoFormat('MM');

        $urutan_max = DB::table('transaksi')->where('cabang_id', $cabang_id)->whereYear('tgl_jam', $tahun)->whereMonth('tgl_jam', $bulan)->max('urutan');
        $urutan = $urutan_max + 1;

        $kode_kuitansi = DB::table('cabang')->where('id', $cabang_id)->value('kode');

        $kode_sub = Str::of($urutan)->padLeft(4, '0');
        $kode = $kode_kuitansi . "/" . $tahun . "/" . $bulan . "/" . $kode_sub;

        $data_pesanan = array();
        $data_pembayaran = array();

        DB::beginTransaction();
        try {
            $id = DB::table('transaksi')->insertGetId([
                'created_at' => now(),
                'created_by' => auth()->user()->id ?? NULL,
                'cabang_id' => $cabang_id,
                'tgl_jam' => now(),
                'urutan' => $urutan,
                'kode' => $kode
            ]);

            $tagihan = 0;
            foreach ($pesanan as $key_pesanan => $val_pesanan) {
                $harga_beda = DB::table('beda_harga')->where('cabang_id', $cabang_id)->where('menu_id', $key_pesanan)->value('harga');
                if (empty($harga_beda)) {
                    $harga = DB::table('menu')->where('id', $key_pesanan)->value('harga');
                } else {
                    $harga = $harga_beda;
                }
                $total = $val_pesanan * $harga;
                $tagihan += $total;

                $data_pesanan[] = [
                    'created_at' => now(),
                    'created_by' => auth()->user()->id ?? NULL,
                    'transaksi_id' => $id,
                    'menu_id' => $key_pesanan,
                    'jumlah' => $val_pesanan,
                    'harga' => $harga,
                    'total' => $total
                ];
            }
            if (count($data_pesanan) > 0) {
                DB::table('transaksi_detail')->insert($data_pesanan);
            }

            $bayar = 0;
            foreach ($pembayaran as $key_pembayaran => $val_pembayaran) {
                if (!empty($val_pembayaran) || $val_pembayaran > 0) {
                    $bayaran = Str::replace('.', '', $val_pembayaran);
                    $bayar += $bayaran;

                    $data_pembayaran[] = [
                        'created_at' => now(),
                        'created_by' => auth()->user()->id ?? NULL,
                        'transaksi_id' => $id,
                        'pembayaran_id' => $key_pembayaran,
                        'nominal' => $bayaran
                    ];
                }
            }
            if (count($data_pembayaran) > 0) {
                DB::table('transaksi_bayar')->insert($data_pembayaran);
            }

            $kembali = $bayar + $diskon - $tagihan;
            DB::table('transaksi')
                ->where('id', $id)
                ->update([
                    'tagihan' => $tagihan,
                    'diskon' => $diskon,
                    'bayar' => $bayar,
                    'kembali' => $kembali
                ]);

            if ($kembali < 0) {
                DB::rollBack();
                return redirect()->route('transaksi.index', ['cabang_id' => $cabang_id])->with('status', ['error', 'Jumlah Pembayaran Kurang']);
            } else {
                DB::commit();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return redirect()->route('transaksi.print', ['cabang_id' => $cabang_id, 'id' => $id])->with('status', ['success', 'Data Berhasil di Tambahkan']);
    }

    public function print($cabang_id, $id)
    {
        $bill = DB::table('transaksi')
            ->join('cabang', 'transaksi.cabang_id', '=', 'cabang.id')
            ->select([
                'transaksi.kode',
                'transaksi.tgl_jam',
                'transaksi.tagihan',
                'transaksi.diskon',
                'transaksi.bayar',
                'transaksi.kembali',
                'cabang.nama',
                'cabang.alamat'
            ])
            ->where('transaksi.id', $id)
            ->first();

        $list_transaksi = DB::table('transaksi_detail')
            ->join('menu', 'transaksi_detail.menu_id', '=', 'menu.id')
            ->select([
                'menu.nama AS nama_menu',
                'transaksi_detail.jumlah AS jumlah_pesan',
                'transaksi_detail.harga AS harga_satuan',
                'transaksi_detail.total AS total_pesan'
            ])
            ->where('transaksi_detail.transaksi_id', $id)
            ->get();

        return view('transaksi_cetak', compact('cabang_id', 'bill', 'list_transaksi'));
    }
}
