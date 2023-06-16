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
        <div class="card-body text-sm px-3 py-2">
          <div class="row">
            <div class="col-md-6">
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
            <div class="col-md-6">
              <div class="form-group">
                <label for="id_gudang">Gudang : </label>
                <div wire:ignore>
                  <select name="id_gudang" id="id_gudang" class="form-control form-control-sm" data-placeholder="- Pilih Gudang -">
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

    $('#id_toko').on('change', function() {
      @this.set('state.id_toko', $(this).val());
    });

    Livewire.on('setSelect2', function(data) {
      if (data.option != null) {
        var newOption = new Option(data.option.text, data.option.value, false, true);
        $('#id_toko').append(newOption);
      }
      $('#id_toko').val(data.value).trigger('change');
    });
  });
</script>
@endpush