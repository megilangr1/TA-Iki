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
        <div class="modal-body py-2 px-3 text-sm {{ $form ? 'd-block':'d-none' }}">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="tanggal_harga">Tanggal Harga : <i class="text-danger">*</i></label>
                <input type="date" wire:model="state.tanggal_harga" name="tanggal_harga" id="tanggal_harga" class="form-control form-control-sm {{ $errors->has('state.tanggal_harga') ? 'is-invalid':'' }}" placeholder="Masukan Tanggal Harga..." min="{{ date('Y-m-d') }}" required>
                <div class="invalid-feedback">
                  {{ $errors->first('state.tanggal_harga') }}
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="keterangan">Keterangan Tambahan :</label>
                <textarea wire:model="state.keterangan" name="keterangan" id="keterangan" cols="1" rows="1" class="form-control form-control-sm {{ $errors->has('state.keterangan') ? 'is-invalid':'' }}" placeholder="Masukan Keterangan Tambahan..."></textarea>
                <div class="invalid-feedback">
                  {{ $errors->first('state.keterangan') }}
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label for="harga">Nominal Harga : <i class="text-danger">*</i></label>
                <input type="text" wire:model="state.harga" name="harga" id="harga" class="form-control form-control-sm {{ $errors->has('state.harga') ? 'is-invalid':'' }}" placeholder="Masukan Nominal Harga..." onkeyup="return formatRupiah(event)" required>
                <div class="invalid-feedback">
                  {{ $errors->first('state.harga') }}
                </div>
              </div>
            </div>
            <div class="col-md-7">
              
              <div class="form-group">
                <label for="diskon">Nominal Diskon (Fix) : <i class="text-danger">*</i></label>
                <div class="input-group input-group-sm">
                  <input type="text" wire:model="state.diskon" name="diskon" id="diskon" class="form-control form-control-sm {{ $errors->has('state.diskon') ? 'is-invalid':'' }}" placeholder="0" onkeyup="return formatRupiah(event)" required>
                  <span class="input-group-append">
                    <button type="button" class="btn btn-secondary btn-flat" wire:click="discount('10')">10%</button>
                    <button type="button" class="btn btn-secondary btn-flat" wire:click="discount('20')">20%</button>
                    <button type="button" class="btn btn-secondary btn-flat" wire:click="discount('30')">30%</button>
                    <button type="button" class="btn btn-secondary btn-flat" wire:click="discount('40')">40%</button>
                    <button type="button" class="btn btn-secondary btn-flat" wire:click="discount('50')">50%</button>
                  </span>
                </div>
                <div class="invalid-feedback">
                  {{ $errors->first('state.diskon') }}
                </div>
              </div>
            </div>
            {{-- <div class="col-md-4">
              <div class="form-group">
                <label for="diskon_range">Persentase Diskon ({{ $state['diskon_range'] . '%' }})</label>
                <input type="range" wire:model="state.diskon_range" class="form-control form-control-sm" id="diskon_range">
              </div>
            </div> --}}
            <div class="col-md-3">
              <button class="btn btn-success btn-xs btn-block" wire:click="{{ $state['id'] != null ? 'updateData':'createData' }}">
                <i class="fa fa-plus"></i> &ensp; {{ $state['id'] != null ? 'Simpan Data':'Buat Data' }}
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
                    <td class="align-middle text-center p-2" colspan="5"> - Belum Ada Data Gudang - </td>
                  </tr>
                @endforelse
              @else
                <tr>
                  <td class="align-middle text-center p-2" colspan="5"> - Silahkan Pilih Ulang Toko - </td>
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
