<div>
  <div class="row">
    <div class="col-12">
      <div class="card card-outline card-success">
        <div class="card-header">
          <h4 class="card-title" wire:click="dummy"> <i class="fa fa-plus-circle text-sm text-success"></i> &ensp; {{ $penerimaanBarang != null && $penerimaanBarang['status'] == true ? 'Detail':'Form' }} Penerimaan Barang </h4>
          <div class="card-tools">
            <a href="{{ route('penerimaan-barang.index') }}" class="btn btn-xs btn-danger px-3"> <i class="fa fa-arrow-left"></i> &ensp; Kembali</a>
          </div>
        </div>
        <div class="card-body text-sm p-0">
          <div class="row px-3 py-2">
            <div class="col-md-12">
              <div class="form-group {{ $pengirimanBarang != null || $penerimaanBarang != null && $penerimaanBarang['status'] == 1 ? 'd-none' : 'd-block' }}">
                <button class="btn btn-block btn-xs btn-outline-info" wire:click="openModalDataPengiriman">
                  <i class="fa fa-table"></i> &ensp; Pilih Data Permintaan Barang
                </button>
              </div>
            </div>
            
            <div class="col-12 {{ $pengirimanBarang != null ? 'd-block' : 'd-none' }}">
              <div class="row">
                @if ($pengirimanBarang == null)
                  <div class="col-md-8">
                    <div class="form-group">
                      <button class="btn btn-block btn-xs btn-info">
                        <span class="fa fa-eye mr-3"></span> Detail Permintaan Barang
                      </button>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <button class="btn btn-block btn-xs btn-danger" wire:click="resetPermintaanBarang">
                        <span class="fa fa-undo mr-3"></span> Reset Data
                      </button>
                    </div>
                  </div>
                @endif
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="toko_pengiriman_dari">Pengiriman Dari (Toko): </label>
                    <input type="text" wire:model="pengirimanBarang.toko_tujuan.nama_toko" name="toko_pengiriman_dari" id="toko_pengiriman_dari" class="form-control form-control-sm" disabled>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="gudang_pengiriman_dari">Pengiriman Dari (Gudang): </label>
                    <input type="text" wire:model="pengirimanBarang.gudang_tujuan.nama_gudang" name="gudang_pengiriman_dari" id="gudang_pengiriman_dari" class="form-control form-control-sm" disabled>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="toko_tujuan_pengiriman">Tujuan Pengiriman (Toko): </label>
                    <input type="text" wire:model="pengirimanBarang.toko.nama_toko" name="toko_tujuan_pengiriman" id="toko_tujuan_pengiriman" class="form-control form-control-sm" disabled>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="gudang_tujuan_pengiriman">Tujuan Pengiriman (Gudang): </label>
                    <input type="text" wire:model="pengirimanBarang.gudang.nama_gudang" name="gudang_tujuan_pengiriman" id="gudang_tujuan_pengiriman" class="form-control form-control-sm" disabled>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 {{ $pengirimanBarang != null ? 'd-none' : 'd-block' }}">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="id_toko">Toko : </label>
                    <div wire:ignore>
                      <select name="id_toko" id="id_toko" class="form-control form-control-sm" data-placeholder="- Silahkan Pilih Toko -" style="width: 100% !important;" {{ $penerimaanBarang != null && $penerimaanBarang['status'] == true ? 'disabled':'' }}>
                        @if ($penerimaanBarang != null && isset($penerimaanBarang['toko']) && $penerimaanBarang['toko'] != null)
                          <option value="{{ $penerimaanBarang['toko']['id'] }}" selected>{{ $penerimaanBarang['toko']['nama_toko'] }}</option>
                        @else
                          <option value=""></option>
                        @endif
                      </select>
                    </div>
                    <div class="text-danger text-xs">
                      {{ $errors->first('state.id_toko') }}
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="id_gudang">Gudang : </label>
                    <div wire:ignore>
                      <select name="id_gudang" id="id_gudang" class="form-control form-control-sm" data-placeholder="- Silahkan Pilih Gudang -" style="width: 100% !important;" {{ $penerimaanBarang != null && $penerimaanBarang['status'] == true ? 'disabled':'' }}>
                        @if ($penerimaanBarang != null && isset($penerimaanBarang['gudang']) && $penerimaanBarang['gudang'] != null)
                          <option value="{{ $penerimaanBarang['gudang']['id'] }}" selected>{{ $penerimaanBarang['gudang']['nama_gudang'] }}</option>
                        @else
                          <option value=""></option>
                        @endif
                        <option value=""></option>
                      </select>
                    </div>
                    <div class="text-danger text-xs">
                      {{ $errors->first('state.id_gudang') }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="tanggal_penerimaan">Tanggal Penerimaan : </label>
                <input type="date" wire:model="state.tanggal_penerimaan" name="tanggal_penerimaan" id="tanggal_penerimaan" class="form-control form-control-sm {{ $errors->has('state.tanggal_penerimaan') ? 'is-invalid':'' }}" required {{ $penerimaanBarang != null && $penerimaanBarang['status'] == true ? 'disabled':'' }}>
                <div class="invalid-feedback">
                  {{ $errors->first('state.tanggal_penerimaan') }}
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="keterangan">Keterangan : </label>
                <textarea wire:model="state.keterangan" name="keterangan" id="keterangan" cols="1" rows="1" class="form-control form-control-sm {{ $errors->has('state.keterangan') ? 'is-invalid':'' }}" placeholder="Masukan Keterangan Penerimaan / Asal Penerimaan" {{ $penerimaanBarang != null && $penerimaanBarang['status'] == true ? 'disabled':'' }}></textarea>
                <div class="invalid-feedback">
                  {{ $errors->first('state.keterangan') }}
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 {{ $penerimaanBarang != null || $pengirimanBarang != null ? 'd-none' : 'd-block'  }}">
              <div class="row">
                <div class="col-12">
                  <h6 class="font-weight-bold bg-teal text-white py-2 px-2 mb-0">Pilih Barang Untuk Menambahkan Data :</h6>
                </div>
                <div class="col-md-11 pl-4 py-2 text-center">
                  <div wire:ignore>
                    <select name="id_barang" id="id_barang" class="form-control form-control-sm" data-placeholder="- Silahkan Pilih Barang -" style="width: 100% !important;">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-1 pr-4 py-2">
                  <button id="resetBarang" class="btn btn-outline-danger btn-sm btn-block">
                    <i class="fa fa-undo"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="col-12">
              <h6 class="font-weight-bold bg-olive text-white py-2 px-2 mb-0" wire:click="$refresh">Daftar Barang Yang di-Terima :</h6>
            </div>
            <div class="col-12 table-responsive">
              <table class="table table-bordered m-0">
                <thead>
                  <tr>
                    <th class="align-middle p-2 text-center" width="5%">No.</th>
                    <th class="align-middle p-2">Nama Barang</th>
                    <th class="align-middle p-2 text-center" width="10%">Jumlah</th>
                    <th class="align-middle p-2" width="40%">Keterangan</th>
                    @if ($penerimaanBarang == null || ($penerimaanBarang != null && $penerimaanBarang['status'] == false))
                      <th class="align-middle p-2 text-center" width="5%">#</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @forelse ($state['detail'] as $key => $item)
                    <tr>
                      <td class="align-middle p-1 text-center">{{ $loop->iteration }}.</td>
                      <td class="align-middle px-2 py-1 {{ $errors->has('state.detail.' . $key . '.id_barang') ? 'text-danger':'' }}">
                        {{ $item['nama_barang'] }}
                        @if ($errors->has('state.detail.' . $key . '.id_barang'))
                          <div class="text-xs font-italic">
                            Data Barang Tidak Valid ! <br> Silahkan Hapus dan Pilih Ulang Data !
                          </div>
                        @endif
                      </td>
                      <td class="align-middle p-1">
                        <input type="number" wire:model="state.detail.{{ $key }}.jumlah" name="jumlah_{{ $key }}" id="jumlah_{{ $key }}" class="form-control form-control-sm {{ $errors->has('state.detail.' . $key . '.jumlah') ? 'is-invalid':'' }}" {{ $penerimaanBarang != null && $penerimaanBarang['status'] == true || $pengirimanBarang != null ? 'disabled':'' }}>
                      </td>
                      <td class="align-middle p-1">
                        <textarea wire:model="state.detail.{{ $key }}.keterangan" name="keterangan_{{ $key }}" id="keterangan_{{ $key }}" cols="1" rows="1" class="form-control form-control-sm {{ $errors->has('state.detail.' . $key . '.keterangan') ? 'is-invalid':'' }}" placeholder="Masukan Keterangan Tambahan..." {{ $penerimaanBarang != null && $penerimaanBarang['status'] == true ? 'disabled':'' }}></textarea>
                      </td>
                      @if ($penerimaanBarang == null || ($penerimaanBarang != null && $penerimaanBarang['status'] == false))
                      <td class="align-middle p-1 text-center">
                        <button class="btn btn-danger btn-xs px-3" wire:click="removeDetail('{{ $key }}')">
                          <i class="fa fa-trash"></i>
                        </button>
                      </td>
                      @endif
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5" class="text-center p-1 {{ $errors->has('state.detail') ? 'bg-danger':'' }}">{{ $errors->has('state.detail') ? 'Detail Penerimaan Stok Barang Tidak Boleh Kosong !':'Belum Ada Data' }}</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="card-footer px-2 py-2">
          <div class="row">
            @if ($penerimaanBarang != null)
              @if ($penerimaanBarang['status'] == false)
                <div class="col-md-3">
                  <button class="btn btn-success btn-block btn-sm" wire:click="updateData">
                    <i class="fa fa-check"></i> &ensp; Simpan Perubahan
                  </button>
                </div>
                @if ($dirty)
                  <div class="col-md-3">
                    <button class="btn btn-danger btn-block btn-sm" wire:click="resetInput">
                      <i class="fa fa-undo"></i> &ensp; Reset Input
                    </button>
                  </div>
                @else
                  <div class="col-md-4">
                    <button class="btn btn-info btn-block btn-sm" wire:click="confirmData">
                      <i class="fa fa-check-circle"></i> &ensp; Konfirmasi Penerimaan Barang
                    </button>
                  </div>
                @endif
              @endif
            @else
              <div class="col-md-5">
                <button class="btn btn-success btn-block btn-sm" wire:click="createData">
                  <i class="fa fa-plus"></i> &ensp; Buat Data Penerimaan Stok Barang
                </button>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  @livewire('pengiriman-barang.modal-data')
</div>

@push('css')
<style>
  .select2-container .select2-selection--single {
    height: 31px !important;
  }
</style>
@endpush

@push('script')
<script>
  $(document).ready(function () {
    $('#id_toko').select2({
      ajax: {
        url: "{{ route('ajax.toko') }}",
        dataType: "json",
        type: "GET",
        delay: 500,
        data: function (params) {
          var query = {
            search: params.term,
          }

          return query;
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
              return {
                text: item.nama_toko,
                id: item.id
              }
            })
          };
        }
      }
    });

    $('#id_gudang').select2();
    Livewire.on('initSelect2Gudang', function(data) {
      $('#id_gudang').val('').trigger('change');
      $('#id_gudang').select2('destroy');

      $('#id_gudang').select2({
        ajax: {
          url: "{{ route('ajax.gudang') }}",
          dataType: "json",
          type: "GET",
          delay: 500,
          data: function (params) {
            var query = {
              search: params.term,
              id_toko: data
            }

            return query;
          },
          processResults: function (data) {
            return {
              results: $.map(data, function (item) {
                return {
                  text: item.nama_gudang,
                  id: item.id
                }
              })
            };
          }
        }
      });
    });

    $('#id_barang').select2({
      ajax: {
        url: "{{ route('ajax.barang') }}",
        dataType: "json",
        type: "GET",
        delay: 500,
        data: function (params) {
          var query = {
            search: params.term,
          }

          return query;
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
              return {
                text: item.nama_barang,
                id: item.id
              }
            })
          };
        }
      }
    });

    $('#id_toko').on('change', function() {
      @this.set('state.id_toko', $(this).val());
    });
    $('#id_gudang').on('change', function() {
      @this.set('state.id_gudang', $(this).val());
    });
    $('#id_barang').on('change', function() {
      @this.set('barang', $(this).val());
    });

    Livewire.on('resetSelect2Barang', function(data) {
      $('#id_barang').val('').trigger('change');
    });

    Livewire.on('setSelect2', function(data) {
      console.log(data);
      if (data != null) {
        $.each(data, function (index, value) { 
          if (value.option != null) {
            var newOption = new Option(value.option.text, value.option.value, false, true);
            $('#' + value.selectId).append(newOption);
          }
          $('#' + value.selectId).val(value.value).trigger('change');
        });
      }
    });

    $('#resetBarang').on('click', function() {
      $('#id_barang').val('').trigger('change');
    });

  });
</script>

@if ($penerimaanBarang != null)
<script>
$(document).ready(function () {
  var id_toko = "{{ $penerimaanBarang['id_toko'] }}";
  $('#id_gudang').select2('destroy');

  $('#id_gudang').select2({
    ajax: {
      url: "{{ route('ajax.gudang') }}",
      dataType: "json",
      type: "GET",
      delay: 500,
      data: function (params) {
        var query = {
          search: params.term,
          id_toko: id_toko
        }

        return query;
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              text: item.nama_gudang,
              id: item.id
            }
          })
        };
      }
    }
  });
});
</script>
@endif
@endpush