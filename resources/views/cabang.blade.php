@extends('layouts/master')

@section('content')
    <div class="card">
        <div class="card-header">
            <strong>Pengaturan Cabang</strong>
            <button class="btn btn-sm btn-primary float-end btn-add" type="button">
                Tambah dong ini
            </button>
        </div>
        <div class="card-body collapse collapse-card">
            <form id="form_cabang" action="" method="post">
                @csrf
                <input id="cabang_id" name="cabang_id" type="hidden">
                <div class="mb-3">
                    <label class="form-label" for="nama">Nama Cabang</label>
                    <input class="form-control" id="nama" name="nama" type="text">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="lokasi">Lokasi</label>
                    <input class="form-control" id="lokasi" name="lokasi" type="text">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="alamat">Alamat</label>
                    <input class="form-control" id="alamat" name="alamat" type="text">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="telpon">Telpon</label>
                    <input class="form-control" id="telpon" name="telpon" type="text">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="kode">Kode</label>
                    <input class="form-control" id="kode" name="kode" type="text">
                </div>
                <button class="btn btn-sm btn-primary" type="submit">Submit</button>
            </form>
        </div>
    </div>

    @if (count($list_cabang) > 0)
        <div class="card mt-3">
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
                                <button class="btn btn-sm btn-warning btn-edit" value="{{ $cabang->id }}">Edit</button>
                                <button class="btn btn-sm btn-danger btn-delete" value="{{ route('cabang.destroy', ['cabang_id' => $cabang->id]) }}">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif
    </div>
@endsection

@push('scripts')
    <script>
        $(".btn-add").click(function() {
            $('#form_cabang').trigger("reset");
            $(".collapse-card").collapse('toggle')
            $("#form_cabang").attr("action", "{{ route('cabang.store') }}");
        });
        $(".btn-edit").click(function() {
            $('#form_cabang').trigger("reset");
            $.post("{{ route('cabang.edit') }}", {
                    _token: "{{ csrf_token() }}",
                    cabang_id: this.value
                },
                function(data, status) {
                    $(".collapse-card").collapse('show')
                    $("#form_cabang").attr("action", "{{ route('cabang.update') }}");
                    $("#cabang_id").val(data.id);
                    $("#nama").val(data.nama);
                    $("#lokasi").val(data.lokasi);
                    $("#alamat").val(data.alamat);
                    $("#telpon").val(data.telpon);
                    $("#kode").val(data.kode);
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
