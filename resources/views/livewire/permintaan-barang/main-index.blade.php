<div>
  <div class="row">
    <div class="col-12">
      <div class="card card-outline card-success">
        <div class="card-header">
          <h4 class="card-title"> <i class="fa fa-sign-in-alt text-success"></i> &ensp; Daftar Permintaan Barang</h4>
          <div class="card-tools">
            <a href="{{ route('permintaan-barang.create') }}" class="btn btn-xs btn-success px-3">
              <i class="fa fa-plus"></i> &ensp; Buat Data
            </a>
          </div>
        </div>
        <div class="card-body p-0 table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="align-middle p-2 text-center" width="5%">No.</th>
                <th class="align-middle p-2 text-center" width="15%">Tanggal Permintaan</th>
                <th class="align-middle p-2 text-center" width="15%">Lokasi Permintaan</th>
                <th class="align-middle p-2 text-center" width="15%">Lokasi Tujuan</th>
                <th class="align-middle p-2 text-center">Jumlah Barang</th>
                <th class="align-middle p-2 text-center" width="20%">Status</th>
                <th class="align-middle p-2 text-center" width="10%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($dataPermintaan as $item)
                <tr>
                  <td class="align-middle p-2 text-center font-weight-bold">{{ ($dataPermintaan->currentpage()-1) * $dataPermintaan->perpage() + $loop->index + 1 }}.</td>
                  <td class="align-middle p-2 text-center">{{ date('d/m/Y', strtotime($item->tanggal_permintaan)) }}</td>
                  <td class="align-middle p-2 text-center">
                    {{ $item->toko->nama_toko }} 
                    <hr class="my-1">
                    {{ $item->gudang->nama_gudang }}
                  </td>
                  <td class="align-middle p-2 text-center">
                    {{ $item->toko_tujuan->nama_toko }} 
                    <hr class="my-1">
                    {{ $item->gudang_tujuan->nama_gudang }}
                  </td>
                  <td class="align-middle p-2 text-center font-weight-bold">{{ $item->detail()->count() }} Jenis Barang</td>
                  <td class="align-middle p-2 text-center font-weight-bold">
                    @switch($item->status)
                      @case(0)
                        <span class="btn btn-block btn-warning btn-xs">
                          Belum Valid
                        </span>
                        @break
                      @case(1)
                        <span class="btn btn-block btn-success btn-xs font-weight-bold">
                          Valid
                        </span>
                        @break
                      @case(2)
                        <span class="btn btn-block btn-danger btn-xs">
                          Di-Batalkan
                        </span>
                        @break
                      @default
                        <span class="btn btn-block btn-secondary btn-xs font-weight-bold">
                          -
                        </span>
                    @endswitch
                  </td>
                  <td class="align-middle p-2 text-center">
                    <div class="btn-group">
                      <a href="{{ route('permintaan-barang.detail', $item->id) }}" class="btn btn-info btn-sm px-3">
                        <i class="fa fa-search"></i>
                      </a>
                      @if ($item->status == 0)
                        <button class="btn btn-danger btn-sm px-3" wire:click="deleteData('{{ $item->id }}')">
                          <i class="fa fa-trash"></i>
                        </button>
                      @endif
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
