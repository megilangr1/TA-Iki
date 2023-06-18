<div>
  <div class="row">
    <div class="col-12">
      <div class="card card-outline card-success">
        <div class="card-header">
          <h4 class="card-title" wire:click="$refresh"> <i class="fa fa-plus-circle text-sm text-success"></i> &ensp; Form Penerimaan Barang </h4>
          <div class="card-tools">
            <a href="{{ route('penerimaan-barang.index') }}" class="btn btn-xs btn-danger px-3"> <i class="fa fa-arrow-left"></i> &ensp; Kembali</a>
          </div>
        </div>
        <div class="card-body text-sm p-0">
          <div class="row px-3 py-2">
            <div class="col-md-4">
              <div class="form-group">
                <label for="id_toko">Toko : </label>
                <div wire:ignore>
                  <select name="id_toko" id="id_toko" class="form-control form-control-sm" data-placeholder="- Silahkan Pilih Toko -" style="width: 100% !important;">
                    <option value=""></option>
                  </select>
                </div>
                <div class="text-danger text-xs">
                  {{ $errors->first('state.id_toko') }}
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="id_gudang">Gudang : </label>
                <div wire:ignore>
                  <select name="id_gudang" id="id_gudang" class="form-control form-control-sm" data-placeholder="- Silahkan Pilih Gudang -" style="width: 100% !important;">
                    <option value=""></option>
                  </select>
                </div>
                <div class="text-danger text-xs">
                  {{ $errors->first('state.id_gudang') }}
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="d-none d-md-block">&ensp;</label>
                <button class="btn btn-block btn-xs btn-info">
                  <i class="fa fa-truck"></i> &ensp; Pilih Pengiriman
                </button>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="tanggal_penerimaan">Tanggal Penerimaan : </label>
                <input type="date" wire:model="state.tanggal_penerimaan" name="tanggal_penerimaan" id="tanggal_penerimaan" class="form-control form-control-sm {{ $errors->has('state.tanggal_penerimaan') ? 'is-invalid':'' }}" required>
                <div class="invalid-feedback">
                  {{ $errors->first('state.tanggal_penerimaan') }}
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="keterangan">Keterangan : </label>
                <textarea wire:model="state.keterangan" name="keterangan" id="keterangan" cols="1" rows="1" class="form-control form-control-sm {{ $errors->has('state.keterangan') ? 'is-invalid':'' }}" placeholder="Masukan Keterangan Penerimaan / Asal Penerimaan"></textarea>
                <div class="invalid-feedback">
                  {{ $errors->first('state.keterangan') }}
                </div>
              </div>
            </div>
          </div>
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
                    <th class="align-middle p-2 text-center" width="5%">#</th>
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
                        <input type="number" wire:model="state.detail.{{ $key }}.jumlah" name="jumlah_{{ $key }}" id="jumlah_{{ $key }}" class="form-control form-control-sm {{ $errors->has('state.detail.' . $key . '.jumlah') ? 'is-invalid':'' }}">
                      </td>
                      <td class="align-middle p-1">
                        <textarea wire:model="state.detail.{{ $key }}.keterangan" name="keterangan_{{ $key }}" id="keterangan_{{ $key }}" cols="1" rows="1" class="form-control form-control-sm {{ $errors->has('state.detail.' . $key . '.keterangan') ? 'is-invalid':'' }}" placeholder="Masukan Keterangan Tambahan..."></textarea>
                      </td>
                      <td class="align-middle p-1 text-center">
                        <button class="btn btn-danger btn-xs px-3" wire:click="removeDetail('{{ $key }}')">
                          <i class="fa fa-trash"></i>
                        </button>
                      </td>
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
            <div class="col-md-5">
              <button class="btn btn-success btn-block btn-sm" wire:click="dummy">
                <i class="fa fa-plus"></i> &ensp; Buat Data Penerimaan Stok Barang
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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
      if (data.option != null) {
        var newOption = new Option(data.option.text, data.option.value, false, true);
        $('#id_toko').append(newOption);
      }
      $('#id_toko').val(data.value).trigger('change');
    });

    $('#resetBarang').on('click', function() {
      $('#id_barang').val('').trigger('change');
    });

  });
</script>
@endpush