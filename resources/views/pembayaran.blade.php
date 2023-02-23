@extends('layouts/master')

@section('content')
    <div class="card">
        <div class="card-header">
            <strong>Pengaturan Pembayaran</strong>
            <button class="btn btn-sm btn-primary float-end btn-add" type="button">
                Tambah
            </button>
        </div>
        <div class="card-body collapse collapse-card">
            <form action="" method="post" id="form_pembayaran">
                @csrf
                <input type="hidden" id="pembayaran_id" name="pembayaran_id">
                <div class="mb-3">
                    <label for="nama" class="form-label">Jenis Pembayaran</label>
                    <input type="text" class="form-control" id="nama" name="nama">
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            </form>
        </div>
    </div>

    @if (count($list_pembayaran) > 0)
        <div class="card mt-3">
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
                                <button class="btn btn-sm btn-warning btn-edit" value="{{ $pembayaran->id }}">Edit</button>
                                <button class="btn btn-sm btn-danger btn-delete" value="{{ route('pembayaran.destroy', ['pembayaran_id' => $pembayaran->id]) }}">Hapus</button>
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
            $('#form_pembayaran').trigger("reset");
            $(".collapse-card").collapse('toggle')
            $("#form_pembayaran").attr("action", "{{ route('pembayaran.store') }}");
        });
        $(".btn-edit").click(function() {
            $('#form_pembayaran').trigger("reset");
            $.post("{{ route('pembayaran.edit') }}", {
                    _token: "{{ csrf_token() }}",
                    pembayaran_id: this.value
                },
                function(data, status) {
                    $(".collapse-card").collapse('show')
                    $("#form_pembayaran").attr("action", "{{ route('pembayaran.update') }}");
                    $("#pembayaran_id").val(data.id);
                    $("#nama").val(data.nama);
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
