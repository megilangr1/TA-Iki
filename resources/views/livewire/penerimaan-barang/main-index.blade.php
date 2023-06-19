<div>
  <div class="row">
    <div class="col-12">
      <div class="card card-outline card-success">
        <div class="card-header">
          <h4 class="card-title"> <i class="fa fa-sign-in-alt text-success"></i> &ensp; Daftar Penerimaan Barang</h4>
          <div class="card-tools">
            <a href="{{ route('penerimaan-barang.create') }}" class="btn btn-xs btn-success px-3">
              <i class="fa fa-plus"></i> &ensp; Buat Data
            </a>
          </div>
        </div>
        <div class="card-body p-0 table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="align-middle p-2 text-center" width="5%">No.</th>
                <th class="align-middle p-2 text-center" width="15%">Tanggal Penerimaan</th>
                <th class="align-middle p-2 text-center" width="15%">Lokasi</th>
                <th class="align-middle p-2 text-center">Jumlah Barang</th>
                <th class="align-middle p-2 text-center">Status</th>
                <th class="align-middle p-2 text-center" width="10%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($dataPenerimaan as $item)
                <tr>
                  <td class="align-middle p-2 text-center font-weight-bold">{{ ($dataPenerimaan->currentpage()-1) * $dataPenerimaan->perpage() + $loop->index + 1 }}.</td>
                  <td class="align-middle p-2 text-center">{{ date('d/m/Y', strtotime($item->tanggal_penerimaan)) }}</td>
                  <td class="align-middle p-2 text-center">
                    {{ $item->toko->nama_toko }} 
                    <hr class="my-1">
                    {{ $item->gudang->nama_gudang }}
                  </td>
                  <td class="align-middle p-2 text-center font-weight-bold">{{ $item->detail()->count() }} Jenis Barang</td>
                  <td class="align-middle p-2 text-center font-weight-bold">
                    <span class="btn btn-block btn-warning btn-xs">
                      Belum Valid
                    </span>
                  </td>
                  <td class="align-middle p-2 text-center">
                    <div class="btn-group">
                      <a href="{{ route('penerimaan-barang.detail', $item->id) }}" class="btn btn-info btn-sm px-3">
                        <i class="fa fa-search"></i>
                      </a>
                      <button class="btn btn-danger btn-sm px-3" wire:click="deleteData('{{ $item->id }}')">
                        <i class="fa fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="align-middle text-center p-1">Belum Ada Data</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="card-footer">

        </div>
      </div>
    </div>
  </div>
</div>
