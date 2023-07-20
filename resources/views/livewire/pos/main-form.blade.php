<div>
  <div class="row pt-3">
    <div class="col-md-6">
      <div class="card card-outline card-success">
        <div class="card-header">
          <h4 class="card-title" wire:click="$refresh">
            <span class="fa fa-boxes mr-3"></span>
            Data Barang
          </h4>
        </div>
        <div class="card-body pt-1">
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
                  <select name="id_gudang" id="id_gudang" class="form-control form-control-sm" data-placeholder="- Silahkan Pilih Gudang -" style="width: 100% !important;">
                    <option value=""></option>
                  </select>
                </div>
                <div class="text-danger text-xs">
                  {{ $errors->first('state.id_gudang') }}
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <input type="text" wire:model="search" name="nama_barang" id="nama_barang" class="form-control" placeholder="Masukan Nama Barang Yang Akan di-Cari...">
              </div>
            </div>
            <div class="col-12 text-sm table-responsive">
              <table class="table table-bordered m-0">
                <thead>
                  <tr>
                    <th class="align-middle px-2 py-1 text-center" width="5%">No.</th>
                    <th class="align-middle px-2 py-1 text-center">Nama Barang</th>
                    <th class="align-middle px-2 py-1 text-center">Stok</th>
                    <th class="align-middle px-2 py-1 text-center">Harga</th>
                    <th class="align-middle px-2 py-1 text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($dataBarang as $item)
                    <tr>
                      <td class="align-middle px-2 py-1 text-center">{{ $loop->iteration }}.</td>
                      <td class="align-middle px-2 py-1 text-center">{{ $item->nama_barang }}</td>
                      <td class="align-middle px-2 py-1 text-center">{{ number_format((double) $item->total_stok, 2, ',' ,'.') }} Unit</td>
                      <td class="align-middle px-2 py-1 text-center">
                        Rp. 
                        @if (isset($item->harga->harga) && isset($item->harga->diskon))
                          {{ number_format((double) ($item->harga->harga - $item->harga->diskon), 2, ',' ,'.') }}
                        @else
                          0
                        @endif
                      </td>
                      <td class="align-middle px-2 py-1 text-center">
                        <button class="btn btn-xs btn-block btn-primary" wire:click="addBarang('{{ $item->id }}')">
                          Pilih Barang
                        </button>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5">Belum Ada Data Barang</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="card-footer">
          {{ print_r($errors->all()) }}
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card card-outline card-success">
        <div class="card-header">
          <h4 class="card-title">
            <span class="fa fa-shopping-cart mr-3"></span>
            Cart Pembelian
          </h4>
        </div>
        <div class="card-body p-0 table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th class="align-middle px-2 py-3 text-center" width="15%">No.</th>
                <th class="align-middle px-2 py-3">Nama Barang</th>
                <th class="align-middle px-2 py-3 text-center" width="20%">Jumlah</th>
                <th class="align-middle px-2 py-1 text-center">Harga</th>
                <th class="align-middle px-2 py-3 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($pos as $key => $item)
                <tr>
                  <td class="align-middle px-2 py-2 text-center font-weight-bold">{{ $loop->iteration }}.</td>
                  <td class="align-middle px-2 py-2">{{ $item['nama_barang'] }}</td>
                  <td class="align-middle px-2 py-2 text-center">
                    <input type="number" wire:model="pos.{{ $key }}.jumlah" name="jumlah_{{ $key }}" id="jumlah_{{ $key }}" class="form-control form-control-sm text-center">
                  </td>
                  <td class="align-middle px-2 py-1 text-center">Rp. {{ number_format((double) $item['harga'], 2, ',' ,'.') }}</td>
                  <td class="align-middle px-2 py-2 text-center">
                    <button class="btn btn-xs btn-danger px-3" wire:click="removeBarang('{{ $key }}')">
                      <span class="fa fa-trash"></span>
                    </button>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="align-middle px-2 py-3 text-center">Belum Ada Data</td>
                </tr>
              @endforelse

              <tr>
                <td colspan="3" class="align-middle px-2 py-2 text-right font-weight-bold">Total : </td>
                <td class="align-middle px-2 py-2 text-center font-weight-bold">Rp. {{ number_format($total, 2, ',', '.') }} </td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer">
          @if (count($pos) > 0)
            <button class="btn btn-block btn-success btn-sm" wire:click="createData">
              <span class="fa fa-check mr-2"></span>
              Selesaikan Transaksi
            </button>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

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

    $('#id_toko').on('change', function() {
      @this.set('toko', $(this).val());
    });
    $('#id_gudang').on('change', function() {
      @this.set('gudang', $(this).val());
    });
  });
</script>
@endpush