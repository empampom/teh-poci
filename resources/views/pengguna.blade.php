@extends('layouts/master')

@section('content')
    <div class="card">
        <div class="card-header">
            <strong>Pengaturan Pengguna</strong>
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse_card" aria-expanded="false" aria-controls="collapse_card">
                Button with data-target
            </button>
            <div class="collapse" id="collapse_card">
                <div class="card-body">
                    <form action="{{ route('pengguna.store') }}" method="post" id="form_pengguna">
                        @csrf
                        <input type="hidden" name="pengguna_id">
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="akses" class="form-label">Akses</label>
                            <select class="form-select" id="akses" name="akses">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cabang</label>
                            <div class="form-check semua">
                                <input class="form-check-input" type="checkbox" value="all" id="cabang_all" name="cabang[]">
                                <label class="form-check-label" for="cabang_all">
                                    Semua
                                </label>
                            </div>
                            @foreach ($list_cabang as $cabang)
                                <div class="form-check satuan">
                                    <input class="form-check-input" type="checkbox" value="{{ $cabang->id }}" id="cabang_{{ $cabang->kode }}" name="cabang[]">
                                    <label class="form-check-label" for="cabang_{{ $cabang->kode }}">
                                        {{ $cabang->nama }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        @if (count($list_pengguna) > 0)
            <div class="card mt-2">
                <div class="card-body">
                    <table class="table table-striped table-bordered align-middle">
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Akses</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($list_pengguna as $pengguna)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pengguna->nama_lengkap }}</td>
                                <td>{{ $pengguna->username }}</td>
                                <td>{{ $pengguna->password }}</td>
                                <td>{{ $pengguna->akses }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning btn-edit" value="{{ $pengguna->id }}">Edit</button>
                                    <a href="" class="btn btn-sm btn-danger">Hapus</a>
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
            $(".semua").click(function() {
                let nilai = document.getElementById("cabang_all").checked;
                if (nilai === false) {
                    $(".satuan").show();
                } else {
                    $(".satuan").hide();
                }
            });
            $(".btn-edit").click(function() {
                $.post("{{ route('pengguna.edit') }}", {
                        _token: "{{ csrf_token() }}",
                        id: this.value
                    },
                    function(data, status) {
                        $("#nama_lengkap").val(data.nama_lengkap);
                        $("#username").val(data.username);
                        $("#password").val(data.password);
                        $("#akses").val(data.akses);
                    });
            });
        </script>
    @endpush
