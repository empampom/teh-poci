@extends('layouts/master')

@section('content')
    <div class="card">
        <div class="card-header">
            <strong>Pengaturan Pembayaran</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('pembayaran.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Jenis Pembayaran</label>
                    <input type="text" class="form-control" id="nama" name="nama">
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            </form>
        </div>
    </div>

    @if (count($list_pembayaran) > 0)
        <div class="card mt-2">
            <div class="card-body">
                <table class="table table-striped table-bordered align-middle">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Jenis Pembayaran</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($list_pembayaran as $pembayaran)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pembayaran->nama }}</td>
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
