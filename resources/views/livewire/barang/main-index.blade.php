<div>
  <div class="row">
    <div class="col-12 {{ $form ? 'd-block':'d-none' }}">
      <div class="card card-outline card-success">
        <div class="card-header">
          <h4 class="card-title" wire:click="$refresh"><i class="fa fa-edit text-sm text-success"></i> &ensp; {{ $state['id'] != null ? 'Edit':'Tambah' }} Data Barang </h4>
          <div class="card-tools">
            <button class="btn btn-xs btn-danger px-3" wire:click="showForm(false)">
              <i class="fa fa-times"></i> &ensp; Tutup Form 
            </button>
          </div>
        </div>
        <div class="card-body py-2 px-3 text-sm">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="id_kategori">Kategori Barang : <i class="text-danger">*</i></label>
                <div wire:ignore>
                  <select name="id_kategori" id="id_kategori" class="form-control form-control-sm" data-placeholder=" - Silahkan Pilih Kategori - " style="width: 100% !important;">
                    <option value=""></option>
                  </select>
                </div>
                <div class="invalid-feedback">
                  {{ $errors->first('state.id_kategori') }}
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="nama_barang">Nama Barang : <i class="text-danger">*</i></label>
                <input type="text" wire:model="state.nama_barang" name="nama_barang" id="nama_barang" class="form-control form-control-sm {{ $errors->has('state.nama_barang') ? 'is-invalid':'' }}" placeholder="Masukan Nama Barang..." required>
                <div class="invalid-feedback">
                  {{ $errors->first('state.nama_barang') }}
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="keterangan">Keterangan : </label>
                <textarea wire:model="state.keterangan" name="keterangan" id="keterangan" cols="1" rows="1" class="form-control form-control-sm {{ $errors->has('state.keterangan') ? 'is-invalid':'' }}" placeholder="Masukan Keterangan..."></textarea>
                <div class="invalid-feedback">
                  {{ $errors->first('state.keterangan') }}
                </div>
              </div>
            </div>
            <div class="col-12">
              <hr class="mt-0">
            </div>
            <div class="col-md-3">
              <button class="btn btn-success btn-sm btn-block" wire:click="{{ $state['id'] != null ? 'updateData':'createData' }}">
                <i class="fa fa-plus"></i> &ensp; {{ $state['id'] != null ? 'Simpan Data':'Buat Data Toko' }}
              </button>
            </div>
            <div class="col-md-3">
              <button class="btn btn-danger btn-sm btn-block" wire:click="showForm(false)">
                <i class="fa fa-times"></i> &ensp; Batalkan Input Data
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <h4 class="card-title"><i class="fa fa-boxes text-sm text-primary"></i> &ensp; Daftar Data Barang</h4>
          <div class="card-tools">
            <button class="btn btn-xs btn-outline-danger px-3" wire:click="$emitTo('component.modal-trashed-data', 'showModalTrashed', 'show')">
              <span class="fa fa-trash"></span> &ensp; Data Terhapus
            </button>
            <button class="btn btn-xs btn-success px-3" wire:click="showForm(true)">
              <i class="fa fa-plus"></i> &ensp; Tambah Data 
            </button>
          </div>
        </div>
        <div class="card-body text-sm p-0 table-repsonsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="align-middle p-2 text-center" width="10%">No.</th>
                <th class="align-middle p-2 text-center" width="15%">Kategori</th>
                <th class="align-middle p-2">Nama Barang</th>
                <th class="align-middle p-2">Keterangan</th>
                <th class="align-middle p-2 text-center" width="10%">#</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($dataBarang as $item)
                <tr>
                  <td class="align-middle py-1 px-2 text-center">{{ ($dataBarang->currentpage()-1) * $dataBarang->perpage() + $loop->index + 1 }}.</td>
                  <td class="align-middle py-1 px-2 text-center">{{ $item->kategori->nama_kategori }}</td>
                  <td class="align-middle py-1 px-2">{{ $item->nama_barang }}</td>
                  <td class="align-middle py-1 px-2">{{ $item->keterangan != null ? $item->keterangan : '-' }}</td>
                  <td class="align-middle py-1 px-2 text-center">
                    <div class="btn-group">
                      <button class="btn btn-info btn-xs px-3" wire:click="$emitTo('barang.modal-harga-barang', 'openModalHargaBarang', '{{ $item->id }}')">
                        <i class="fa fa-money-bill"></i>
                      </button>
                      <button class="btn btn-primary btn-xs px-3" wire:click="$emitTo('barang.modal-stok-barang', 'openModalStokBarang', '{{ $item->id }}')">
                        <i class="fa fa-boxes"></i>
                      </button>
                      <button class="btn btn-xs btn-warning px-3" wire:click="editData('{{ $item->id }}')">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-xs btn-danger px-3" wire:click="deleteData('{{ $item->id }}')">
                        <i class="fa fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center align-middle p-2">- Belum Ada Data -</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-12">
              <div class="float-right text-xs">
                {{ $dataBarang->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @livewire('component.modal-trashed-data', ['modelName' => 'barang'])
  @livewire('barang.modal-harga-barang')
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
    $('#id_kategori').select2({
      ajax: {
        url: "{{ route('ajax.kategori') }}",
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
                text: item.nama_kategori,
                id: item.id
              }
            })
          };
        }
      }
    });

    $('#id_kategori').on('change', function() {
      @this.set('state.id_kategori', $(this).val());
    });

    Livewire.on('setSelect2', function(data) {
      if (data.option != null) {
        var newOption = new Option(data.option.text, data.option.value, false, true);
        $('#id_kategori').append(newOption);
      }
      $('#id_kategori').val(data.value).trigger('change');
    });
  });
</script>
@endpush