@extends('welcome')

@section('title', 'Edit Order')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Nama User</label>
                            <select name="id_user" id="user_id" class="form-control @error('id_user') is-invalid @enderror">
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id_user }}" data-alamat="{{ $user->alamat }}" {{ (old('id_user', $order->id_user) == $user->id_user) ? 'selected' : '' }}>
                                        {{ $user->nama_user }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_user')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $order->alamat) }}" readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Nama Produk</label>
                            <select name="id_produk" id="product_id" class="form-control @error('id_produk') is-invalid @enderror">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id_produk }}" data-harga="{{ $product->harga }}" {{ (old('id_produk', $order->id_produk) == $product->id_produk) ? 'selected' : '' }}>
                                        {{ $product->nama_produk }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_produk')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', $order->product->harga ?? '') }}" readonly>
                            <span id="harga_rupiah" class="form-text text-muted"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Jumlah</label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah', $order->jumlah) }}" placeholder="Masukkan Jumlah">
                            @error('jumlah')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Total Harga</label>
                            <input type="number" class="form-control" id="total_harga" name="total_harga" value="{{ old('total_harga', $order->total_harga) }}" readonly>
                            <span id="total_rupiah" class="form-text text-muted"></span>
                        </div>

                        <button type="submit" class="btn btn-md btn-primary me-3">UPDATE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function formatRupiah(angka) {
        angka = angka || 0;
        return 'Rp ' + parseInt(angka).toLocaleString('id-ID', {minimumFractionDigits: 2});
    }

    function setAlamat() {
        var userSelect = document.getElementById('user_id');
        var alamatInput = document.getElementById('alamat');
        var alamat = '';
        if (userSelect.value) {
            var selectedOption = userSelect.options[userSelect.selectedIndex];
            alamat = selectedOption.getAttribute('data-alamat') || '';
        }
        alamatInput.value = alamat;
    }

    function setHargaAndTotal() {
        var productSelect = document.getElementById('product_id');
        var hargaInput = document.getElementById('harga');
        var jumlahInput = document.getElementById('jumlah');
        var totalInput = document.getElementById('total_harga');
        var hargaRupiah = document.getElementById('harga_rupiah');
        var totalRupiah = document.getElementById('total_rupiah');

        var harga = 0;
        if (productSelect.value) {
            var selectedOption = productSelect.options[productSelect.selectedIndex];
            harga = selectedOption.getAttribute('data-harga') || 0;
        }
        hargaInput.value = harga;
        if (hargaRupiah) hargaRupiah.textContent = formatRupiah(harga);

        var jumlah = parseInt(jumlahInput.value) || 0;
        var total = harga * jumlah;
        totalInput.value = total;
        if (totalRupiah) totalRupiah.textContent = formatRupiah(total);
    }

    document.addEventListener('DOMContentLoaded', function() {
        setAlamat();
        setHargaAndTotal();

        document.getElementById('user_id').addEventListener('change', setAlamat);
        document.getElementById('product_id').addEventListener('change', setHargaAndTotal);
        document.getElementById('jumlah').addEventListener('input', setHargaAndTotal);
    });
</script>
@endsection