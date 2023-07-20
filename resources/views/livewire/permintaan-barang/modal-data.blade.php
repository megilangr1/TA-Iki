<div>
  <div wire:ignore.self class="modal fade" id="modal-data-permintaan">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" wire:click="$refresh">
            <span class="fa fa-table mr-3"></span>
            Data Permintaan Barang
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-0 table-responsive text-sm">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th class="align-middle px-3 py-2 text-center" width="5%">No.</th>
                <th class="align-middle px-3 py-2 text-center" width="15%">Tanggal Permintaan</th>
                <th class="align-middle px-3 py-2" width="20%">Permintaan Dari</th>
                <th class="align-middle px-3 py-2" width="20%">Meminta Ke</th>
                <th class="align-middle px-3 py-2 text-center" width="20%">Jumlah Jenis Barang</th>
                <th class="align-middle px-3 py-2 text-center" width="15%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($dataPermintaan as $item)
                <tr>
                  <td class="align-middle px-3 py-1 text-center">{{ $loop->iteration }}.</td>
                  <td class="align-middle px-3 py-1 text-center">{{ $item->tanggal_permintaan != null ? date('d/m/Y', strtotime($item->tanggal_permintaan)) : '-' }}</td>
                  <td class="align-middle px-3 py-1">
                    {{ $item->toko->nama_toko }} - {{ $item->gudang->nama_gudang }}
                  </td>
                  <td class="align-middle px-3 py-1">
                    {{ $item->toko_tujuan->nama_toko }} - {{ $item->gudang_tujuan->nama_gudang }}
                  </td>
                  <td class="align-middle px-3 py-1 text-center font-weight-bold">
                    {{ $item->detail_count }} Barang di-Minta
                  </td>
                  <td class="align-middle px-3 py-1" wire:click="selectPermintaanBarang('{{ $item->id }}')">
                    <button class="btn btn-block btn-info btn-xs">
                      Pilih Data
                    </button>
                  </td>
                </tr>
              @empty
                <tr>
                  <td class="align-middle px-3 py-1 text-center" colspan="6">Belum Ada Data</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="modal-footer justify-content-end">
          {{ $dataPermintaan->links() }}
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>

@push('script')
<script>
  $(document).ready(function () {
    Livewire.on('modal-data-permintaan', function(showProps) {
      $('#modal-data-permintaan').modal(showProps);
    });
  });
</script>
@endpush