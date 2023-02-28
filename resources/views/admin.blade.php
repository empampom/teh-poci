@extends('layouts/master')

@section('content')
    <div class="row">
        <div class="col-sm-4 mb-3">
            <div class="card">
                <div class="card-header">
                    <h3>Transaksi Dong Ah</h3>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('transaksi.home') }}" class="btn btn-danger">Buka</a>
                </div>
            </div>
        </div>
        @if (auth()->user()->akses == 'admin')
            <div class="col-sm-4 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h3>Pengaturan Pengguna</h3>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ route('pengguna.index') }}" class="btn btn-primary">Buka</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h3>Pengaturan Cabang</h3>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ route('cabang.index') }}" class="btn btn-primary">Buka</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h3>Pengaturan Pembayaran</h3>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-primary">Buka</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h3>Pengaturan Menu</h3>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ route('menu.index') }}" class="btn btn-primary">Buka</a>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-sm-4 mb-3">
            <div class="card">
                <div class="card-header">
                    <h3>Laporan</h3>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('laporan.index') }}" class="btn btn-primary">Buka</a>
                </div>
            </div>
        </div>
    </div>
@endsection
