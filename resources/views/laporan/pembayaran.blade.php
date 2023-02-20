@extends('layouts/master')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
    <h2 class="text-center">LAPORAN PEMBAYARAN</h2>
    <div class="table-responsive">
        <table class="table table-bordered align-middle" id="datatable">
            <thead class="text-center">
                <tr>
                    <th>#</th>
                    <th>Cabang</th>
                    <th>Pembayaran</th>
                    <th>Nominal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grand_total = 0;
                @endphp
                @foreach ($list_pembayaran as $val_pembayaran)
                    @php
                        $grand_total += $val_pembayaran->total_bayar;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $val_pembayaran->nama_cabang }}</td>
                        <td>{{ $val_pembayaran->nama_bayar }}</td>
                        <td class="text-end">{{ number_format($val_pembayaran->total_bayar, 0, '.', ',') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="fw-bold text-center">Total</td>
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
                    filename: "Laporan Pembayaran Periode {{ date('d/m/Y', strtotime($tgl_awal)) }} - {{ date('d/m/Y', strtotime($tgl_akhir)) }}",
                    title: null
                }]
            });
        });
    </script>
@endpush
