@extends('layouts/master')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
    <h2 class="text-center">LAPORAN PENJUALAN</h2>
    <div class="table-responsive">
        <table class="table table-bordered align-middle" id="datatable">
            <thead class="text-center">
                <tr>
                    <th>#</th>
                    <th>Cabang</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Kode</th>
                    <th>Detail</th>
                    <th>Diskon</th>
                    <th>Bill</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $diskon_total = 0;
                    $grand_total = 0;
                @endphp
                @foreach ($list_penjualan as $val_penjualan)
                    @php
                        $diskon_total += $val_penjualan->diskon;
                        $grand_total += $val_penjualan->tagihan;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $val_penjualan->nama_cabang }}</td>
                        <td>{{ date('d/m/Y', strtotime($val_penjualan->tgl_jam)) }}</td>
                        <td>{{ date('H:i', strtotime($val_penjualan->tgl_jam)) }}</td>
                        <td>{{ $val_penjualan->kode }}</td>
                        <td>
                            <ol class="table table-borderless my-0 py-0 px-3">
                                @foreach ($list_penjualan_detail as $key_penjualan_detail => $val_penjualan_detail)
                                    @if ($val_penjualan->id == $val_penjualan_detail->id)
                                        <li>
                                            <span>{{ $val_penjualan_detail->nama_menu }}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </td>
                        <td class="text-end">{{ number_format($val_penjualan->diskon, 0, '.', ',') }}</td>
                        <td class="text-end">{{ number_format($val_penjualan->tagihan, 0, '.', ',') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="fw-bold text-center">Total</td>
                <td class="fw-bold text-end">{{ number_format($diskon_total, 0, '.', ',') }}</td>
                <td class="fw-bold text-end">{{ number_format($grand_total, 0, '.', ',') }}</td>
            </tr>
        </table>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                paging: false,
                info: false,
                dom: 'B',
                buttons: [{
                    extend: 'excelHtml5',
                    filename: "Laporan Penjualan Periode {{ date('d/m/Y', strtotime($tgl_awal)) }} - {{ date('d/m/Y', strtotime($tgl_akhir)) }}",
                    title: null
                }]
            });
        });
    </script>
@endpush
