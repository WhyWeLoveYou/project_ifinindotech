@extends('welcome')

@section('title', 'Add Order')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Nama User</label>
                            <select name="id_user" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id_user }}" data-alamat="{{ $user->alamat }}" {{ old('user_id') == $user->id_user ? 'selected' : '' }}>
                                        {{ $user->nama_user }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Nama Produk</label>
                            <select name="id_produk" id="product_id" class="form-control @error('product_id') is-invalid @enderror">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id_produk }}" data-harga="{{ $product->harga }}" {{ old('product_id') == $product->id_produk ? 'selected' : '' }}>
                                        {{ $product->nama_produk }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" readonly>
                            <span id="harga_rupiah" class="form-text text-muted"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Jumlah</label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" placeholder="Masukkan Jumlah">
                            @error('jumlah')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Total Harga</label>
                            <input type="number" class="form-control" id="total_harga" name="total_harga" value="{{ old('total_harga') }}" readonly>
                            <span id="total_rupiah" class="form-text text-muted"></span>
                        </div>

                        <button type="submit" class="btn btn-md btn-primary me-3">SAVE</button>
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
        hargaRupiah.textContent = formatRupiah(harga);

        var jumlah = parseInt(jumlahInput.value) || 0;
        var total = harga * jumlah;
        totalInput.value = total;
        totalRupiah.textContent = formatRupiah(total);
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