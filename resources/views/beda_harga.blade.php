@extends('layouts/master')

@section('content')
    <div class="card">
        <div class="card-header">
            <strong>Pengaturan Harga Beda</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('beda_harga.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="cabang" class="form-label">Cabang</label>
                    <select class="form-select" id="cabang" name="cabang_id">
                        @foreach ($list_cabang as $cabang)
                            <option value="{{ $cabang->id }}">{{ $cabang->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="menu" class="form-label">Menu</label>
                    <select class="form-select" id="menu" name="menu_id">
                        @foreach ($list_menu as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga">
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    @if (count($list_beda_harga) > 0)
        <div class="card mt-2">
            <div class="card-body">
                <h2 class="text-center">List Harga Beda</h2>
                <table class="table table-striped table-bordered align-middle">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Cabang</th>
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($list_beda_harga as $beda_harga)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $beda_harga->nama_cabang }}</td>
                            <td>{{ $beda_harga->nama_menu }}</td>
                            <td class="text-end">{{ number_format($beda_harga->harga_beda, 0, '.', ',') }}</td>
                            <td class="text-center">
                                <a href="" class="btn btn-sm btn-warning">Edit</a>
                                <a href="" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif
@endsection
