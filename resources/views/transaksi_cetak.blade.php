@extends('layouts/plain')

@push('styles')
    <style>
        body {
            font-family: 'Montserrat';
        }
    </style>
@endpush

@section('content')
    <p class="text-center p-0 m-0">{{ $bill->nama }}</p>
    <p class="text-center p-0 m-0" style="font-size: 12px">{{ $bill->alamat }}</p>
    <p class="p-0 m-0">{{ $bill->kode }}</p>
    <p class="p-0 m-0">{{ date('d/m/Y H:i', strtotime($bill->tgl_jam)) }}</p>
    <div class="p-0 my-1 border-top border-dark border-3"></div>
    <table class="table-borderless w-100">
        @foreach ($list_transaksi as $transaksi)
            <tr>
                <td style="width: 1%; white-space: nowrap;">{{ $loop->iteration }}. </td>
                <td colspan="3">{{ $transaksi->nama_menu }}</td>
            </tr>
            <tr class="text-end">
                <td colspan="2" class="text-end">{{ number_format($transaksi->harga_satuan, 0, '.', ',') }}</td>
                <td class="text-end">{{ number_format($transaksi->jumlah_pesan, 0, '.', ',') }}</td>
                <td class="text-end">{{ number_format($transaksi->total_pesan, 0, '.', ',') }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" class="text-end">Total</td>
            <td class="text-end border-top border-dark border-3 fw-bold">{{ number_format($bill->tagihan, 0, '.', ',') }}</td>
        </tr>
        <tr>
            <td colspan="3" class="text-end">Diskon</td>
            <td class="text-end">{{ number_format($bill->diskon, 0, '.', ',') }}</td>
        </tr>
        <tr>
            <td colspan="3" class="text-end">Pembayaran</td>
            <td class="text-end">{{ number_format($bill->bayar, 0, '.', ',') }}</td>
        </tr>
        @if ($bill->kembali > 0)
            <tr>
                <td colspan="3" class="text-end">Kembali</td>
                <td class="text-end">{{ number_format($bill->kembali, 0, '.', ',') }}</td>
            </tr>
        @endif
    </table>
    <center>
        <button class="btn btn-sm btn-primary d-print-none" onclick="window.print()">Print</button>
        <a href="{{ route('transaksi.index', ['cabang_id' => $cabang_id]) }}" class="btn btn-sm btn-success d-print-none">Selesai</a>
    </center>
@endsection
