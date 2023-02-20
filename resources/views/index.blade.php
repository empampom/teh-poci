@extends('layouts/master')

@section('content')
    <div class="row">
        @foreach ($list_cabang as $cabang)
            <div class="col-sm-4 mb-1">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ $cabang->nama }}</h3>
                    </div>
                    <div class="card-body text-center">
                        <p>{{ $cabang->lokasi }}</p>
                        <a href="{{ route('transaksi.index', ['cabang_id' => $cabang->id]) }}" class="btn btn-primary">Buka</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
