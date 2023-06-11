<div>
  <div wire:ignore.self class="modal fade" id="modal-gudang-toko" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal-gudang-tokoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content" style="background-clip: border-box !important;">
        <div class="modal-header" wire:click="$refresh">
          <h5 class="modal-title" id="modal-gudang-tokoLabel"><i class="fas fa-table"></i> &ensp; Daftar Gudang - {{ $toko != null ? $toko['nama_toko'] : '-' }} </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body py-2 px-3 text-sm {{ $form ? 'd-block':'d-none' }}">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="nama_gudang">Nama Gudang : <i class="text-danger">*</i></label>
                <input type="text" wire:model="state.nama_gudang" name="nama_gudang" id="nama_gudang" class="form-control form-control-sm {{ $errors->has('state.nama_gudang') ? 'is-invalid':'' }}" placeholder="Masukan Nama Gudang..." required>
                <div class="invalid-feedback">
                  {{ $errors->first('state.nama_gudang') }}
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="alamat_gudang">Alamat Gudang :</label>
                <textarea wire:model="state.alamat_gudang" name="alamat_gudang" id="alamat_gudang" cols="1" rows="1" class="form-control form-control-sm {{ $errors->has('state.alamat_gudang') ? 'is-invalid':'' }}" placeholder="Masukan Alamat Gudang..."></textarea>
                <div class="invalid-feedback">
                  {{ $errors->first('state.alamat_gudang') }}
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <button class="btn btn-success btn-xs btn-block" wire:click="{{ $state['id'] != null ? 'updateData':'createData' }}">
                <i class="fa fa-plus"></i> &ensp; {{ $state['id'] != null ? 'Simpan Data':'Buat Data Toko' }}
              </button>
            </div>
            <div class="col-md-3">
              <button class="btn btn-danger btn-xs btn-block" wire:click="showForm(false)">
                <i class="fa fa-times"></i> &ensp; Batalkan Input Data
              </button>
            </div>
            <div class="col-12">
            </div>
          </div>
        </div>
        <div class="modal-body p-0 text-sm">
          <h6 class="font-weight-bold bg-secondary mb-0 p-3">
            List Data Gudang 
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
                <th class="align-middle p-2">Nama Gudang</th>
                <th class="align-middle p-2">Alamat Gudang</th>
                <th class="align-middle p-2 text-center" width="20%">Status</th>
                <th class="align-middle p-2 text-center" width="10%">#</th>
              </tr>
            </thead>
            <tbody>
              @if ($toko != null && isset($toko['gudang_with_trashed']))
                @forelse ($toko['gudang_with_trashed'] as $item)
                  <tr>
                    <td class="align-middle px-2 py-1 text-center">{{ $loop->iteration }}.</td>
                    <td class="align-middle px-2 py-1">{{ $item['nama_gudang'] }}</td>
                    <td class="align-middle px-2 py-1">{{ $item['alamat_gudang'] != null ? $item['alamat_gudang'] : '-' }}</td>
                    <td class="align-middle px-2 py-1 text-center">
                      @if ($item['deleted_at'] != null)
                        <button class="btn btn-danger btn-xs btn-block">
                          Non-Aktif / Di-Hapus
                        </button>
                      @else
                        <button class="btn btn-info btn-xs btn-block">
                          Aktif
                        </button>
                      @endif
                    </td>
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
                    <td class="align-middle text-center p-2" colspan="4"> - Belum Ada Data Gudang - </td>
                  </tr>
                @endforelse
              @else
                <tr>
                  <td class="align-middle text-center p-2" colspan="4"> - Silahkan Pilih Ulang Toko - </td>
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
    Livewire.on('gudang-toko-modal', function(val) {
      $('#modal-gudang-toko').modal(val);
    });
  });
</script>
@endpush
