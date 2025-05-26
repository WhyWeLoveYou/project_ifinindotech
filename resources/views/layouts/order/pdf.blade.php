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
    <h2>Order Detail</h2>
    <table>
        <tr>
            <th>User</th>
            <td>{{ $order->user->nama_user }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $order->alamat }}</td>
        </tr>
        <tr>
            <th>Total Harga</th>
            <td>{{ 'Rp ' . number_format($order->total_harga, 2, ',', '.') }}</td>
        </tr>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->details as $i => $detail)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $detail->product->nama_produk }}</td>
                <td>{{ 'Rp ' . number_format($detail->harga, 2, ',', '.') }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td>{{ 'Rp ' . number_format($detail->subtotal, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>