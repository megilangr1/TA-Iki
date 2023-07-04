<div>
  <div wire:ignore.self class="modal fade" id="modal-stok-barang" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal-stok-barangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content" style="background-clip: border-box !important;">
        <div class="modal-header" wire:click="$refresh">
          <h5 class="modal-title" id="modal-stok-barangLabel"><i class="fas fa-table"></i> &ensp; Daftar Stok {{ $barang['nama_barang'] ?? '' }} </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body py-1">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="toko">Toko : </label>
                <div wire:ignore>
                  <select name="toko" id="toko" class="form-control form-control-sm" data-placeholder="- Silahkan Pilih Toko -" style="width: 100% !important;">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="gudang">Gudang : </label>
                <div wire:ignore>
                  <select name="gudang" id="gudang" class="form-control form-control-sm" data-placeholder="- Silahkan Pilih Gudang -" style="width: 100% !important;">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label class="d-none d-md-block">&ensp;</label>
                <button class="btn btn-block btn-sm btn-outline-info" wire:click="loadStok">
                  Load Data
                </button>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label class="d-none d-md-block">&ensp;</label>
                <button class="btn btn-block btn-sm btn-danger" wire:click="loadAllStok">
                  Reset
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body p-0 table-responsive text-sm">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th class="align-middle px-3 py-1 text-center" width="5%">No.</th>
                <th class="align-middle px-3 py-1">Lokasi</th>
                <th class="align-middle px-3 py-1 text-center">Stok</th>
              </tr>
            </thead>
            <tbody>
              @if (isset($stokData['data']))
                @forelse ($stokData['data'] as $item)
                  <tr>
                    <td class="align-middle px-3 py-1 text-center">{{ $loop->iteration }}.</td>
                    <td class="align-middle px-3 py-1">{{ $item['toko']['nama_toko'] . ' - ' . $item['gudang']['nama_gudang'] }}</td>
                    <td class="align-middle px-3 py-1 text-center font-weight-bold">{{ $item['perubahan_stok'] }} Buah</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="align-middle px-3 py-1">Belum Ada Data</td>
                  </tr>
                @endforelse

                @if (isset($stokData['totalStok']))
                  <tr class="bg-secondary">
                    <th colspan="2" class="align-middle px-3 py-1 text-right">Total : </th>
                    <th class="align-middle px-3 py-1 text-center">{{ $stokData['totalStok'] }}</th>
                  </tr>
                @endif 
              @else 
                <tr>
                  <td colspan="3" class="align-middle px-3 py-1">Belum Ada Data</td>
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
    Livewire.on('stok-barang-modal', function(val) {
      $('#modal-stok-barang').modal(val);
    });

    $('#toko').select2({
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

    $('#gudang').select2();
    Livewire.on('initSelect2Gudang', function(data) {
      $('#gudang').val('').trigger('change');
      $('#gudang').select2('destroy');

      $('#gudang').select2({
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

    $('#toko').on('change', function() {
      @this.set('state.id_toko', $(this).val());
    });

    $('#gudang').on('change', function() {
      @this.set('state.id_gudang', $(this).val());
    });

    Livewire.on('setSelect2', function(data) {
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

  });
</script>
@endpush
