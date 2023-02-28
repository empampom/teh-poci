@extends('layouts/master')

@section('content')
    @if (count($list_menu) > 0)
        <div class="row">
            @foreach ($list_menu as $menu)
                @php
                    $gambar = 'gambar_menu/' . $menu->gambar;
                    $harga = $menu->harga;
                @endphp
                <div class="col-4 m-0 p-1">
                    <div class="card">
                        <img src="{{ asset($gambar) }}" class="card-img-top">
                        <div class="card-body text-center pt-0">
                            <strong>{{ number_format($harga, 0, '.', ',') }}</strong>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text text-white fw-bold bg-success" id="kurang-{{ $menu->id }}" data-target="jumlah-{{ $menu->id }}" onclick="kurangPesanan(this)">-</span>
                                <input type="number" class="form-control jumlah-pesanan" name="jumlah[{{ $menu->id }}]" id="jumlah-{{ $menu->id }}" data-id="{{ $menu->id }}" data-nama="{{ $menu->nama }}" data-harga="{{ $harga }}" value="0" readonly>
                                <span class="input-group-text text-white fw-bold bg-success" id="tambah-{{ $menu->id }}" data-target="jumlah-{{ $menu->id }}" onclick="tambahPesanan(this)">+</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row mt-2" style="font-size: 10px">
            <div class="col-12">
                <h2 class="text-center" id="judul-pesan">List Pesanan</h2>
                <form action="{{ route('transaksi.store', ['cabang_id' => $cabang_id]) }}" method="post" autocomplete="off" id="form-transaksi">
                    @csrf
                    <table class="table table-striped my-1" id="tabel-pesanan"></table>
                    <div class="row">
                        <div class="col-12">
                            <table class="mt-1 float-end" id="tabel-bayar">
                                @foreach ($list_pembayaran as $pembayaran)
                                    <tr>
                                        <td class="text-end p-2">{{ $pembayaran->nama }}</td>
                                        <td>
                                            <input type="text" inputmode="numeric" class="form-control form-control-sm m-0 p-0 number-separator text-end fw-bold" name="pembayaran[{{ $pembayaran->id }}]">
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="my-1 float-end" id="tabel-diskon">
                                <tr>
                                    <td class="text-end p-2">Diskon</td>
                                    <td>
                                        <input type="text" inputmode="numeric" class="form-control form-control-sm m-0 p-0 number-separator text-end fw-bold" name="diskon">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
                <br>
            </div>
        </div>
        <button type="submit" class="btn btn-sm btn-success float-end mb-3" id="tombol-pesan" form="form-transaksi">Bayar</button>
    @endif
@endsection

@push('scripts')
    <script>
        function kurangPesanan(param) {
            let target = param.getAttribute("data-target");
            let jumlah_now = parseInt(document.getElementById(target).value);
            if (jumlah_now > 0) {
                let jumlah_pesanan = jumlah_now - 1;
                document.getElementById(target).value = jumlah_pesanan;
                listPesanan()
            }
        }

        function tambahPesanan(param) {
            let target = param.getAttribute("data-target");
            let jumlah_now = parseInt(document.getElementById(target).value);
            let jumlah_pesanan = jumlah_now + 1;
            document.getElementById(target).value = jumlah_pesanan;
            listPesanan()
        }

        function nominal(param) {
            return param.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        inputNominal({
            selector: '.number-separator',
            separator: '.'
        })

        function listPesanan() {
            let list_menu = document.getElementsByClassName("jumlah-pesanan");
            let list = "";
            var grand_total = 0;
            for (let i = 0; i < list_menu.length; i++) {
                var id = list_menu.item(i).getAttribute("data-id");
                var nama = list_menu.item(i).getAttribute("data-nama");
                var harga = list_menu.item(i).getAttribute("data-harga");
                var jumlah = list_menu.item(i).value;
                var total = harga * jumlah;
                grand_total += total;
                if (jumlah > 0) {
                    list += "<tr>" +
                        "<td class='w-50'>" + nama + "</td>" +
                        "<td class='text-end'>" + nominal(harga) + "</td>" +
                        "<td>" + "<input type='number' readonly class='form-control-plaintext text-end m-0 p-0' name='pesanan[" + id + "]' value='" + jumlah + "'>" + "</td>" +
                        "<td class='text-end'>" + nominal(total) + "</td>" +
                        "</tr>";
                }
            }
            if (list != "") {
                list += "<tr class='fw-bold'>" + "<td colspan='3' class='text-center'>Total</td>" + "<td class='text-end'>" + nominal(grand_total) + "</td>" + "</tr>";
                document.getElementById("judul-pesan").style.display = "block";
                document.getElementById("tabel-bayar").style.display = "block";
                document.getElementById("tabel-diskon").style.display = "block";
                document.getElementById("tombol-pesan").style.display = "block";
            } else {
                document.getElementById("judul-pesan").style.display = "none";
                document.getElementById("tabel-bayar").style.display = "none";
                document.getElementById("tabel-diskon").style.display = "none";
                document.getElementById("tombol-pesan").style.display = "none";
            }
            document.getElementById("tabel-pesanan").innerHTML = list;
        }
        listPesanan();
    </script>
@endpush
