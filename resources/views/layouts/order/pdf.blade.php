<!DOCTYPE html>
<html>
<head>
    <title>Order PDF</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; }
    </style>
</head>
<body>
    <h2>Order List</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Alamat</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->user->nama_user }}</td>
                <td>{{ $order->alamat }}</td>
                <td>{{ $order->product->nama_produk }}</td>
                <td>{{ number_format($order->product->harga, 2, ',', '.') }}</td>
                <td>{{ $order->jumlah }}</td>
                <td>{{ number_format($order->total_harga, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>