<div>
  <div class="row">
    <div class="col-12">
      <div class="card card-outline card-success">
        <div class="card-header">
          <h4 class="card-title" wire:click="dummy"> <i class="fa fa-plus-circle text-sm text-success"></i> &ensp; {{ $pengirimanBarang != null && $pengirimanBarang['status'] == true ? 'Detail':'Form' }} Pengiriman Barang </h4>
          <div class="card-tools">
            <a href="{{ route('pengiriman-barang.index') }}" class="btn btn-xs btn-danger px-3"> <i class="fa fa-arrow-left"></i> &ensp; Kembali</a>
          </div>
        </div>
        <div class="card-body text-sm p-0">
          <div class="row px-3 py-2">
            <div class="col-md-12">
              <div class="form-group {{ $permintaanBarang != null ? 'd-none' : 'd-block' }}">
                <button class="btn btn-block btn-xs btn-outline-info" wire:click="openModalPermintaanBarang">
                  <i class="fa fa-table"></i> &ensp; Pilih Data Permintaan Barang
                </button>
              </div>
            </div>
            <div class="col-12 {{ $permintaanBarang != null ? 'd-block' : 'd-none' }}">
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <button class="btn btn-block btn-xs btn-info">
                      <span class="fa fa-eye mr-3"></span> Detail Permintaan Barang
                    </button>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <button class="btn btn-block btn-xs btn-danger" wire:click="resetForm">
                      <span class="fa fa-undo mr-3"></span> Reset Data
                    </button>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="toko_pengiriman_dari">Pengiriman Dari (Toko): </label>
                    <input type="text" wire:model="permintaanBarang.toko_tujuan.nama_toko" name="toko_pengiriman_dari" id="toko_pengiriman_dari" class="form-control form-control-sm" disabled>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="gudang_pengiriman_dari">Pengiriman Dari (Gudang): </label>
                    <input type="text" wire:model="permintaanBarang.gudang_tujuan.nama_gudang" name="gudang_pengiriman_dari" id="gudang_pengiriman_dari" class="form-control form-control-sm" disabled>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="toko_tujuan_pengiriman">Tujuan Pengiriman (Toko): </label>
                    <input type="text" wire:model="permintaanBarang.toko.nama_toko" name="toko_tujuan_pengiriman" id="toko_tujuan_pengiriman" class="form-control form-control-sm" disabled>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="gudang_tujuan_pengiriman">Tujuan Pengiriman (Gudang): </label>
                    <input type="text" wire:model="permintaanBarang.gudang.nama_gudang" name="gudang_tujuan_pengiriman" id="gudang_tujuan_pengiriman" class="form-control form-control-sm" disabled>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 {{ $permintaanBarang != null ? 'd-none' : 'd-block' }}">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="id_toko">Toko Asal : </label>
                    <div wire:ignore>
                      <select name="id_toko" id="id_toko" class="form-control form-control-sm" data-placeholder="- Silahkan Pilih Toko -" style="width: 100% !important;" {{ $pengirimanBarang != null && $pengirimanBarang['status'] == true ? 'disabled':'' }}>
                        @if ($pengirimanBarang != null && isset($pengirimanBarang['toko']) && $pengirimanBarang['toko'] != null)
                          <option value="{{ $pengirimanBarang['toko']['id'] }}" selected>{{ $pengirimanBarang['toko']['nama_toko'] }}</option>
                        @else
                          <option value=""></option>
                        @endif
                      </select>
                    </div>
                    <div class="text-danger text-xs">
                      {{ $errors->first('state.id_toko') }}
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="id_gudang">Gudang Asal : </label>
                    <div wire:ignore>
                      <select name="id_gudang" id="id_gudang" class="form-control form-control-sm" data-placeholder="- Silahkan Pilih Gudang -" style="width: 100% !important;" {{ $pengirimanBarang != null && $pengirimanBarang['status'] == true ? 'disabled':'' }}>
                        @if ($pengirimanBarang != null && isset($pengirimanBarang['gudang']) && $pengirimanBarang['gudang'] != null)
                          <option value="{{ $pengirimanBarang['gudang']['id'] }}" selected>{{ $pengirimanBarang['gudang']['nama_gudang'] }}</option>
                        @else
                          <option value=""></option>
                        @endif
                      </select>
                    </div>
                    <div class="text-danger text-xs">
                      {{ $errors->first('state.id_gudang') }}
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="id_toko_tujuan">Toko Tujuan : </label>
                    <div wire:ignore>
                      <select name="id_toko_tujuan" id="id_toko_tujuan" class="form-control form-control-sm" data-placeholder="- Silahkan Pilih Toko Tujuan -" style="width: 100% !important;" {{ $pengirimanBarang != null && $pengirimanBarang['status'] == true ? 'disabled':'' }}>
                        @if ($pengirimanBarang != null && isset($pengirimanBarang['toko_tujuan']) && $pengirimanBarang['toko_tujuan'] != null)
                          <option value="{{ $pengirimanBarang['toko_tujuan']['id'] }}" selected>{{ $pengirimanBarang['toko_tujuan']['nama_toko'] }}</option>
                        @else
                          <option value=""></option>
                        @endif
                      </select>
                    </div>
                    <div class="text-danger text-xs">
                      {{ $errors->first('state.id_toko_tujuan') }}
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="id_gudang_tujuan">Gudang Tujuan : </label>
                    <div wire:ignore>
                      <select name="id_gudang_tujuan" id="id_gudang_tujuan" class="form-control form-control-sm" data-placeholder="- Silahkan Pilih Gudang Tujuan -" style="width: 100% !important;" {{ $pengirimanBarang != null && $pengirimanBarang['status'] == true ? 'disabled':'' }}>
                        @if ($pengirimanBarang != null && isset($pengirimanBarang['gudang_tujuan']) && $pengirimanBarang['gudang_tujuan'] != null)
                          <option value="{{ $pengirimanBarang['gudang_tujuan']['id'] }}" selected>{{ $pengirimanBarang['gudang_tujuan']['nama_gudang'] }}</option>
                        @else
                          <option value=""></option>
                        @endif
                      </select>
                    </div>
                    <div class="text-danger text-xs">
                      {{ $errors->first('state.id_gudang_tujuan') }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="tanggal_pengiriman">Tanggal Pengiriman : </label>
                <input type="date" wire:model="state.tanggal_pengiriman" name="tanggal_pengiriman" id="tanggal_pengiriman" class="form-control form-control-sm {{ $errors->has('state.tanggal_pengiriman') ? 'is-invalid':'' }}" required {{ $pengirimanBarang != null && $pengirimanBarang['status'] == true ? 'disabled':'' }}>
                <div class="invalid-feedback">
                  {{ $errors->first('state.tanggal_pengiriman') }}
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="keterangan">Keterangan : </label>
                <textarea wire:model="state.keterangan" name="keterangan" id="keterangan" cols="1" rows="1" class="form-control form-control-sm {{ $errors->has('state.keterangan') ? 'is-invalid':'' }}" placeholder="Masukan Keterangan Pengiriman / Asal Pengiriman" {{ $pengirimanBarang != null && $pengirimanBarang['status'] == true ? 'disabled':'' }}></textarea>
                <div class="invalid-feedback">
                  {{ $errors->first('state.keterangan') }}
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 {{ $pengirimanBarang != null || $permintaanBarang != null ? 'd-none' : 'd-block'  }}">
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
              <h6 class="font-weight-bold bg-olive text-white py-2 px-2 mb-0" wire:click="$refresh">Daftar Barang Yang di-Kirim :</h6>
            </div>
            <div class="col-12 table-responsive">
              <table class="table table-bordered m-0">
                <thead>
                  <tr>
                    <th class="align-middle p-2 text-center" width="5%">No.</th>
                    <th class="align-middle p-2">Nama Barang</th>
                    <th class="align-middle p-2 text-center" width="10%">Jumlah</th>
                    <th class="align-middle p-2" width="40%">Keterangan</th>
                    @if ($pengirimanBarang == null || ($pengirimanBarang != null && $pengirimanBarang['status'] == false))
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

                        <a href="#" wire:click="openModalStok('{{ $item['id_barang'] }}')">
                          <span class="fa fa-table px-3"></span>
                        </a>
                      </td>
                      <td class="align-middle p-1">
                        <input type="number" wire:model="state.detail.{{ $key }}.jumlah" name="jumlah_{{ $key }}" id="jumlah_{{ $key }}" class="form-control form-control-sm {{ $errors->has('state.detail.' . $key . '.jumlah') ? 'is-invalid':'' }}" {{ ($pengirimanBarang != null && $pengirimanBarang['status'] == true) || $permintaanBarang != null ? 'disabled':'' }}>
                      </td>
                      <td class="align-middle p-1">
                        <textarea wire:model="state.detail.{{ $key }}.keterangan" name="keterangan_{{ $key }}" id="keterangan_{{ $key }}" cols="1" rows="1" class="form-control form-control-sm {{ $errors->has('state.detail.' . $key . '.keterangan') ? 'is-invalid':'' }}" placeholder="Masukan Keterangan Tambahan..." {{ $pengirimanBarang != null && $pengirimanBarang['status'] == true ? 'disabled':'' }}></textarea>
                      </td>
                      @if ($pengirimanBarang == null || ($pengirimanBarang != null && $pengirimanBarang['status'] == false))
                      <td class="align-middle p-1 text-center">
                        <button class="btn btn-danger btn-xs px-3" wire:click="removeDetail('{{ $key }}')">
                          <i class="fa fa-trash"></i>
                        </button>
                      </td>
                      @endif
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5" class="text-center p-1 {{ $errors->has('state.detail') ? 'bg-danger':'' }}">{{ $errors->has('state.detail') ? 'Detail Pengiriman Stok Barang Tidak Boleh Kosong !':'Belum Ada Data' }}</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="card-footer px-2 py-2">
          <div class="row">
            @if ($pengirimanBarang != null)
              @switch($pengirimanBarang['status'])
                @case(0)
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
                        <i class="fa fa-check-circle"></i> &ensp; Konfirmasi Pengiriman Barang
                      </button>
                    </div>
                  @endif
                  @break
                @case(1)
                  <div class="col-md-4">
                    <button class="btn btn-danger btn-block btn-sm" wire:click="cancelData">
                      <i class="fa fa-times-circle"></i> &ensp; Batalkan Pengiriman
                    </button>
                  </div>
                  @break
                @default
              @endswitch
            @else
              <div class="col-md-5">
                <button class="btn btn-success btn-block btn-sm" wire:click="createData">
                  <i class="fa fa-plus"></i> &ensp; Buat Data Pengiriman Stok Barang
                </button>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  @livewire('permintaan-barang.modal-data')
  @livewire('barang.modal-stok-barang')
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

    $('#id_toko_tujuan').select2({
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

    $('#id_gudang_tujuan').select2();
    Livewire.on('initSelect2GudangTujuan', function(data) {
      $('#id_gudang_tujuan').val('').trigger('change');
      $('#id_gudang_tujuan').select2('destroy');

      $('#id_gudang_tujuan').select2({
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
    $('#id_toko_tujuan').on('change', function() {
      @this.set('state.id_toko_tujuan', $(this).val());
    });
    $('#id_gudang_tujuan').on('change', function() {
      @this.set('state.id_gudang_tujuan', $(this).val());
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

@if ($pengirimanBarang != null)
<script>
$(document).ready(function () {
  var id_toko = "{{ $pengirimanBarang['id_toko'] }}";
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

  var id_toko_tujuan = "{{ $pengirimanBarang['id_toko_tujuan'] }}";
  $('#id_gudang_tujuan').select2('destroy');

  $('#id_gudang_tujuan').select2({
    ajax: {
      url: "{{ route('ajax.gudang') }}",
      dataType: "json",
      type: "GET",
      delay: 500,
      data: function (params) {
        var query = {
          search: params.term,
          id_toko: id_toko_tujuan
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