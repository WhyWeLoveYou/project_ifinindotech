@extends('welcome')

@section('title', 'Product List')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <a href="{{ route('orders.create') }}" class="btn btn-md btn-success mb-3">Add Orders</a>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 5%">No</th>
                                <th scope="col">Nama User</th>
                                <th scope="col">Nama Produk</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Jumlah Beli</th>
                                <th scope="col">Total Harga</th>
                                <th scope="col" style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                @foreach ($order->details as $i => $detail)
                                    <tr>
                                        @if ($i == 0)
                                            <td rowspan="{{ $order->details->count() }}">
                                                {{ $loop->parent->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}
                                            </td>
                                            <td rowspan="{{ $order->details->count() }}">
                                                {{ $order->user->nama_user }}
                                            </td>
                                        @endif
                                        <td>{{ $detail->product->nama_produk }}</td>
                                        <td>{{ 'Rp ' . number_format($detail->harga, 2, ',', '.') }}</td>
                                        <td>{{ $detail->jumlah }}</td>
                                        @if ($i == 0)
                                            <td rowspan="{{ $order->details->count() }}">
                                                {{ 'Rp ' . number_format($order->total_harga, 2, ',', '.') }}
                                            </td>
                                            <td rowspan="{{ $order->details->count() }}" class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                    action="{{ route('orders.destroy', $order->id) }}"
                                                    method="POST">
                                                    <a href="{{ route('orders.print_pdf', $order->id) }}"
                                                        class="btn btn-sm btn-dark">Print</a>
                                                    <a href="{{ route('orders.edit', $order->id) }}"
                                                        class="btn btn-sm btn-primary">Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforelse
                        </tbody>
                    </table>
                    {{ $orders->links() }}
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
