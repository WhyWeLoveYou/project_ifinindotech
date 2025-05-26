 @extends('welcome')

    @section('title', 'User List')

    @section('content')
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded">
                        <div class="card-body">
                            <a href="{{ route('users.create') }}" class="btn btn-md btn-success mb-3">Add User</a>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 5%">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col" style="width: 20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                            <td>{{ $user->nama_user }}</td>
                                            <td>{{ $user->alamat }}</td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                    action="{{ route('users.destroy', $user->id_user) }}"
                                                    method="POST">
                                                    <a href="{{ route('users.edit', $user->id_user) }}"
                                                        class="btn btn-sm btn-primary">Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if (session('success'))
                Swal.fire({
                    icon: "success",
                    title: "BERHASIL",
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2000
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: "error",
                    title: "GAGAL!",
                    text: "{{ session('error') }}",
                    showConfirmButton: false,
                    timer: 2000
                });
            @endif
        </script>
    @endsection

    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @endsection
