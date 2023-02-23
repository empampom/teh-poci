@extends('layouts/master')

@section('content')
    <div class="card">
        <div class="card-header">
            <strong>Pengaturan Menu</strong>
            <button class="btn btn-sm btn-primary float-end btn-add" type="button">
                Tambah
            </button>
        </div>
        <div class="card-body collapse collapse-card">
            <form action="" method="post" id="form_menu" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="menu_id" name="menu_id">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Menu</label>
                    <input type="text" class="form-control" id="nama" name="nama">
                </div>
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar</label>
                    <input class="form-control" type="file" id="gambar" name="gambar">
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga">
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    <a href="{{ route('beda_harga.index') }}" class="btn btn-sm btn-warning">Beda Harga</a>
                </div>
            </form>
        </div>
    </div>

    @if (count($list_menu) > 0)
        <div class="card mt-3">
            <div class="card-body">
                <h2 class="text-center">List Menu</h2>
                <table class="table table-striped table-bordered align-middle">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Harga Default</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($list_menu as $menu)
                        @php
                            $gambar = 'gambar_menu/' . $menu->gambar;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-center"><img src="{{ asset($gambar) }}" style="height:100px"></td>
                            <td>{{ $menu->nama }}</td>
                            <td class="text-end">{{ number_format($menu->harga, 0, '.', ',') }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning btn-edit" value="{{ $menu->id }}">Edit</button>
                                <button class="btn btn-sm btn-danger btn-delete" value="{{ route('menu.destroy', ['menu_id' => $menu->id]) }}">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        $(".btn-add").click(function() {
            $('#form_menu').trigger("reset");
            $(".collapse-card").collapse('toggle')
            $("#form_menu").attr("action", "{{ route('menu.store') }}");
        });
        $(".btn-edit").click(function() {
            $('#form_menu').trigger("reset");
            $.post("{{ route('menu.edit') }}", {
                    _token: "{{ csrf_token() }}",
                    menu_id: this.value
                },
                function(data, status) {
                    $(".collapse-card").collapse('show')
                    $("#form_menu").attr("action", "{{ route('menu.update') }}");
                    $("#menu_id").val(data.id);
                    $("#nama").val(data.nama);
                    $("#harga").val(data.harga);
                });
        });
        $(".btn-delete").click(function() {
            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = this.value;
                }
            })
        });
    </script>
@endpush