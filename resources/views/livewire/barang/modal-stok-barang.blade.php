<div>
  <div wire:ignore.self class="modal fade" id="modal-harga-barang" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal-harga-barangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content" style="background-clip: border-box !important;">
        <div class="modal-header" wire:click="$refresh">
          <h5 class="modal-title" id="modal-harga-barangLabel"><i class="fas fa-table"></i> &ensp; Harga Barang - {{ $barang != null ? $barang['nama_barang'] : '-' }} </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-0 text-sm">
          <h6 class="font-weight-bold bg-secondary mb-0 p-3">
            List Harga Barang 
            <div class="float-right">
              <button class="btn btn-success btn-xs px-3" wire:click="showForm(true)">
                <i class="fa fa-plus"></i> &ensp; Tambah Data
              </button>
            </div>
          </h6>
        </div>
        <div class="modal-body p-0 text-xs table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th class="align-middle p-2 text-center" width="10%">No.</th>
                <th class="align-middle p-2 text-center" width="15%">Tanggal Harga</th>
                <th class="align-middle p-2">Harga</th>
                <th class="align-middle p-2">Diskon</th>
                <th class="align-middle p-2">Keterangan</th>
                <th class="align-middle p-2 text-center" width="10%">#</th>
              </tr>
            </thead>
            <tbody>
              @if ($barang != null && isset($barang['harga_with_trashed']))
                @forelse ($barang['harga_with_trashed'] as $item)
                  <tr>
                    <td class="align-middle px-2 py-1 text-center">{{ $loop->iteration }}.</td>
                    <td class="align-middle px-2 py-1 text-center font-weight-bold">{{ date('d/m/Y', strtotime($item['tanggal_harga'])) }}</td>
                    <td class="align-middle px-2 py-1">Rp. {{ number_format($item['harga'], 2, ',', '.') }}</td>
                    <td class="align-middle px-2 py-1">Rp. {{ number_format($item['diskon'], 2, ',', '.') }}</td>
                    <td class="align-middle px-2 py-1">{{ $item['keterangan'] != null ? $item['keterangan'] : '-' }}</td>
                    <td class="align-middle px-2 py-1 text-center">
                      <div class="btn-group">
                        @if ($item['deleted_at'] != null)
                          <button class="btn btn-info btn-xs px-4" wire:click="restoreData('{{ $item['id'] }}')">
                            <i class="fa fa-undo"></i>
                          </button>
                        @else
                        <button class="btn btn-warning btn-xs px-3" wire:click="editData('{{ $item['id'] }}')">
                          <i class="fa fa-edit"></i>
                        </button>
                          <button class="btn btn-danger btn-xs px-3" wire:click="deleteData('{{ $item['id'] }}')">
                            <i class="fa fa-trash"></i>
                          </button>
                        @endif
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td class="align-middle text-center p-2" colspan="6"> - Belum Ada Data Gudang - </td>
                  </tr>
                @endforelse
              @else
                <tr>
                  <td class="align-middle text-center p-2" colspan="6"> - Silahkan Pilih Ulang Toko - </td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
        <div class="modal-footer text-sm">
          <button class="btn btn-primary" wire:click="$refresh">
            Refresh
          </button>
          <button class="btn btn-secondary" wire:click="dummy">
            Dummy
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

@push('css')
<style>
  .pagination {
    margin: 0px !important;
  }

  .page-item.active .page-link {
    background-color: var(--custom-color-1) !important;
    border-color: #fff !important;
  }
</style>
@endpush

@push('script')
<script>
  $(document).ready(function () {
    Livewire.on('harga-barang-modal', function(val) {
      $('#modal-harga-barang').modal(val);
    });
  });
</script>
@endpush
