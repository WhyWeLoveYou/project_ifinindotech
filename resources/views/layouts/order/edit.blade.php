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

                        <label class="font-weight-bold">Produk</label>
                        <table class="table table-bordered" id="produk_table">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="produk_body">
                                @foreach($order->details as $detail)
                                <tr>
                                    <td>
                                        <select name="id_produk[]" class="form-control produk-select" required>
                                            <option value="">-- Pilih Produk --</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id_produk }}" data-harga="{{ $product->harga }}"
                                                    {{ $detail->id_produk == $product->id_produk ? 'selected' : '' }}>
                                                    {{ $product->nama_produk }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control harga-input" name="harga[]" value="{{ $detail->harga }}" readonly>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control jumlah-input" name="jumlah[]" min="1" value="{{ $detail->jumlah }}" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control subtotal-input" name="subtotal[]" value="{{ $detail->subtotal }}" readonly>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-row">-</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success btn-sm mb-3" id="add_row">+ Tambah Produk</button>

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

    function updateRow(row) {
        var select = row.querySelector('.produk-select');
        var hargaInput = row.querySelector('.harga-input');
        var jumlahInput = row.querySelector('.jumlah-input');
        var subtotalInput = row.querySelector('.subtotal-input');

        var harga = 0;
        if (select.value) {
            var selectedOption = select.options[select.selectedIndex];
            harga = selectedOption.getAttribute('data-harga') || 0;
        }
        hargaInput.value = harga;

        var jumlah = parseInt(jumlahInput.value) || 0;
        var subtotal = harga * jumlah;
        subtotalInput.value = subtotal;
    }

    function updateTotal() {
        var subtotalInputs = document.querySelectorAll('.subtotal-input');
        var total = 0;
        subtotalInputs.forEach(function(input) {
            total += parseInt(input.value) || 0;
        });
        document.getElementById('total_harga').value = total;
        document.getElementById('total_rupiah').textContent = formatRupiah(total);
    }

    function bindRowEvents(row) {
        row.querySelector('.produk-select').addEventListener('change', function() {
            updateRow(row);
            updateTotal();
        });
        row.querySelector('.jumlah-input').addEventListener('input', function() {
            updateRow(row);
            updateTotal();
        });
        row.querySelector('.remove-row').addEventListener('click', function() {
            if (document.querySelectorAll('#produk_body tr').length > 1) {
                row.remove();
                updateTotal();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        setAlamat();
        document.getElementById('user_id').addEventListener('change', setAlamat);

        // Bind events for all existing rows
        document.querySelectorAll('#produk_body tr').forEach(function(row) {
            bindRowEvents(row);
            updateRow(row);
        });
        updateTotal();

        document.getElementById('add_row').addEventListener('click', function() {
            var tbody = document.getElementById('produk_body');
            var firstRow = tbody.querySelector('tr');
            var newRow = firstRow.cloneNode(true);

            // Reset values
            newRow.querySelector('.produk-select').selectedIndex = 0;
            newRow.querySelector('.harga-input').value = '';
            newRow.querySelector('.jumlah-input').value = 1;
            newRow.querySelector('.subtotal-input').value = '';

            bindRowEvents(newRow);
            tbody.appendChild(newRow);
            updateTotal();
        });
    });
</script>
@endsection