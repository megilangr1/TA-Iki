<div>
  <div wire:ignore.self class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal-detailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content" style="background-clip: border-box !important;">
        <div class="modal-header" wire:click="$refresh">
          <h5 class="modal-title" id="modal-detailLabel"><i class="fas fa-table"></i> &ensp; Detail Pegawai - {{ $pegawai != null ? $pegawai['nama_pegawai'] : '-' }} </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-0">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12 p-0 text-sm">
                <ul class="nav nav-tabs" id="tab-detail-barang" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" wire:ignore.self id="tab-detail-barang-informasi-tab" data-toggle="pill" href="#tab-detail-barang-informasi" role="tab" aria-controls="tab-detail-barang-informasi" aria-selected="true">Informasi Utama</a>
                  </li>
                  @if (isset($detail['lokasi']) || isset($detail['tanda_batas_tanah']))
                    <li class="nav-item">
                      <a class="nav-link" wire:ignore.self id="tab-detail-barang-lokasi-tab" data-toggle="pill" href="#tab-detail-barang-lokasi" role="tab" aria-controls="tab-detail-barang-lokasi" aria-selected="false">Lokasi</a>
                    </li>
                  @endif
                  @if (isset($detail['spesifikasi_lainnya']))
                    <li class="nav-item">
                      <a class="nav-link" wire:ignore.self id="tab-detail-barang-spesifikasi-lainnya-tab" data-toggle="pill" href="#tab-detail-barang-spesifikasi-lainnya" role="tab" aria-controls="tab-detail-barang-spesifikasi-lainnya" aria-selected="false">Spesifikasi Lainnya</a>
                    </li>
                  @endif
                </ul>
              </div>
              <div class="col-12 p-0 text-sm">
                <h6 class="bg-secondary text-white p-0 m-0" style="font-size: 3px !important;">&ensp;</h6>
              </div>
              <div class="col-12">
                <div class="tab-content" id="tab-detail-barangContent">
                  <div class="tab-pane fade show active" wire:ignore.self id="tab-detail-barang-informasi" role="tabpanel" aria-labelledby="tab-detail-barang-informasi-tab">
                    <div class="row">
                      <div class="col-12 p-0 text-xs table-responsive">
                        <table class="table table-hover m-0" style="min-width: 600px !important;">
                          <tr class="bg-secondary">
                            <th class="align-middle px-3 py-2" colspan="7">Informasi Detail Pegawai</th>
                          </tr>
                          <tr>
                            <th class="align-middle px-3 py-2">Nama Pegawai</th>
                            <th class="align-middle px-0 py-2 text-center">:</th>
                            <th class="align-middle px-3 py-2">{{ $pegawai['nama_pegawai'] ?? '-' }}</th>
                            <th></th>
                            <th class="align-middle px-3 py-2">Toko</th>
                            <th class="align-middle px-0 py-2 text-center">:</th>
                            <th class="align-middle px-3 py-2">{{ $pegawai['toko']['nama_toko'] ?? '-' }}</th>
                          </tr>
                          <tr>
                            <th class="align-top px-3 py-2" width="15%">Email Pegawai</th>
                            <th class="align-top px-0 py-2 text-center" width="2%">:</th>
                            <th class="align-middle px-3 py-2">{{ $pegawai['user']['email'] ?? '-' }}</th>
                            <th></th>
                            <th class="align-middle px-3 py-2">Tanggal Data Dibuat</th>
                            <th class="align-middle px-0 py-2 text-center">:</th>
                            <th class="align-middle px-3 py-2">{{ isset($pegawai['created_at']) && $pegawai['created_at'] != null ? date('d/m/Y', strtotime($pegawai['created_at'])) : '-' }}</th>
                          </tr>
                          </tr>  
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
</style>
@endpush

@push('script')
<script>
  $(document).ready(function () {
    Livewire.on('modal-detail', function(val) {
      $('#modal-detail').modal(val);
    });
  });
</script>
@endpush