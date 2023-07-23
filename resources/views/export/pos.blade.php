<table>
    <thead>
    <tr>
        <th>No.</th>
        <th>Tanggal Transaksi</th>
        <th>Toko</th>
        <th>Gudang</th>
        <th>User</th>
        <th>Total Barang</th>
        <th>Total Penjualan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pos as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->tanggal_transaksi }}</td>
            <td>{{ $item->toko->nama_toko }}</td>
            <td>{{ $item->gudang->nama_gudang }}</td>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->detail_count }}</td>
            <td>{{ $item->detail_sum_sub_total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>