<div>
  <div class="row">
    <div class="col-12">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <h4 class="card-title">
            <span class="fa fa-shopping-cart mr-3 text-primary"></span>
            Data Point Of Sales
          </h4>

          <div class="card-tools">
            <a href="{{ route('point-of-sales') }}" class="btn btn-xs btn-primary px-3">
              <span class="fa fa-plus mr-2"></span>
              Tambah Data Baru
            </a>
          </div>
        </div>
        
        <div class="card-body p-0 table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="align-middle px-3 py-2 text-center">No.</th>
                <th class="align-middle px-3 py-2 text-center">Tanggal Transaksi</th>
                <th class="align-middle px-3 py-2 text-center">Toko - Gudang</th>
                <th class="align-middle px-3 py-2 text-center">User</th>
                <th class="align-middle px-3 py-2 text-center">Total Barang</th>
                <th class="align-middle px-3 py-2 text-center">Total Penjualan</th>
                <th class="align-middle px-3 py-2 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($dataPos as $item)
                <tr>
                  <td class="align-middle px-3 py-2 text-center">{{ $loop->iteration }}.</td>
                  <td class="align-middle px-3 py-2 text-center">{{ date('d/m/Y H:i:s', strtotime($item->tanggal_transaksi)) }}</td>
                  <td class="align-middle px-3 py-2 text-center">{{ $item->toko->nama_toko ?? '-' }} - {{ $item->gudang->nama_gudang ?? '-' }}</td>
                  <td class="align-middle px-3 py-2 text-center">{{ $item->user->name }}</td>
                  <td class="align-middle px-3 py-2 text-center">{{ count($item->detail) }} Barang</td>
                  <td class="align-middle px-3 py-2 text-center">Rp. {{ number_format($item->detail()->sum('sub_total'), 2, ',', '.') }}</td>
                  <td class="align-middle px-3 py-2 text-center">
                    <button class="btn btn-danger btn-xs">
                      <span class="fa fa-trash"></span>
                    </button>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7">
                    Belum Ada Data Point Of Sales
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
