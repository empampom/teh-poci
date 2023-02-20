@extends('layouts/master')

@section('content')
    <div class="card">
        <div class="card-header">
            <strong>Laporan</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('laporan.result') }}" method="post" target="_blank">
                @csrf
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis Laporan</label>
                    <select name="jenis" class="form-select" id="jenis">
                        <option value="penjualan">Laporan Penjualan</option>
                        <option value="pembayaran">Laporan Pembayaran</option>
                        <option value="terlaris">Laporan Menu Terlaris</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="cabang_id" class="form-label">Cabang</label>
                    <select name="cabang_id" class="form-select" id="cabang_id">
                        <option value="all">Semua Cabang</option>
                        @foreach ($list_cabang as $cabang)
                            <option value="{{ $cabang->id }}">{{ $cabang->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Periode</label>
                    <div class="input-group">
                        <input type="date" class="form-control" name="tgl_awal" value="{{ date('Y-m-d') }}">
                        <span class="input-group-text">s/d</span>
                        <input type="date" class="form-control" name="tgl_akhir" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <center>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </center>
            </form>
        </div>
    </div>
@endsection
