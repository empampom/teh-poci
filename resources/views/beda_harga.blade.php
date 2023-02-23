@extends('layouts/master')

@section('content')
    <div class="card">
        <div class="card-header">
            <strong>Pengaturan Harga Beda</strong>
            <button class="btn btn-sm btn-primary float-end btn-add" type="button">
                Tambah
            </button>
        </div>
        <div class="card-body collapse collapse-card">
            <form action="" method="post" id="form_beda_harga">
                @csrf
                <input type="hidden" id="beda_harga_id" name="beda_harga_id">
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
        <div class="card mt-3">
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
                                <button class="btn btn-sm btn-warning btn-edit" value="{{ $beda_harga->id }}">Edit</button>
                                <button class="btn btn-sm btn-danger btn-delete" value="{{ route('beda_harga.destroy', ['beda_harga_id' => $beda_harga->id]) }}">Hapus</button>
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
            $('#form_beda_harga').trigger("reset");
            $(".collapse-card").collapse('toggle')
            $("#form_beda_harga").attr("action", "{{ route('beda_harga.store') }}");
        });
        $(".btn-edit").click(function() {
            $('#form_beda_harga').trigger("reset");
            $.post("{{ route('beda_harga.edit') }}", {
                    _token: "{{ csrf_token() }}",
                    beda_harga_id: this.value
                },
                function(data, status) {
                    $(".collapse-card").collapse('show')
                    $("#form_beda_harga").attr("action", "{{ route('beda_harga.update') }}");
                    $("#beda_harga_id").val(data.id);
                    $("#cabang_id").val(data.cabang_id);
                    $("#menu_id").val(data.menu_id);
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
