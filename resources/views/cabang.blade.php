@extends('layouts/master')

@section('content')
    <div class="card">
        <div class="card-header">
            <strong>Pengaturan Cabang</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('cabang.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Cabang</label>
                    <input type="text" class="form-control" id="nama" name="nama">
                </div>
                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi">
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat">
                </div>
                <div class="mb-3">
                    <label for="telpon" class="form-label">Telpon</label>
                    <input type="text" class="form-control" id="telpon" name="telpon">
                </div>
                <div class="mb-3">
                    <label for="kode" class="form-label">Kode</label>
                    <input type="text" class="form-control" id="kode" name="kode">
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            </form>
        </div>
    </div>

    @if (count($list_cabang) > 0)
        <div class="card mt-2">
            <div class="card-body">
                <table class="table table-striped table-bordered align-middle">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Nama Cabang</th>
                        <th>Lokasi</th>
                        <th>Alamat</th>
                        <th>Telpon</th>
                        <th>Kode</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($list_cabang as $cabang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cabang->nama }}</td>
                            <td>{{ $cabang->lokasi }}</td>
                            <td>{{ $cabang->alamat }}</td>
                            <td>{{ $cabang->telpon }}</td>
                            <td>{{ $cabang->kode }}</td>
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
