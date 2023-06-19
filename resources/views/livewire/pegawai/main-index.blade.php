<div>
  <div class="row">
    <div class="col-12 {{ $form ? 'd-block':'d-none' }}">
      <div class="card card-outline card-success">
        <div class="card-header">
          <h4 class="card-title" wire:click="$refresh"><i class="fa fa-edit text-sm text-success"></i> &ensp; {{ $state['id'] != null ? 'Edit':'Tambah' }} Data Pegawai</h4>
          <div class="card-tools">
            <button class="btn btn-xs btn-danger px-3" wire:click="showForm(false)">
              <i class="fa fa-times"></i> &ensp; Tutup Form
            </button>
          </div>
        </div>
        <div class="card-body px-3 py-2 text-sm">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="id_toko">Nama Toko :</label>
                <div wire:ignore>
                  <select name="id_toko" id="id_toko" class="form-control form-control-sm" data-placeholder="- Silahkan Pilih Toko -" style="width: 100% !important;">
                    <option value=""></option>
                  </select>
                </div>
                <div class="invalid-feedback">
                  {{ $errors->first('state.id_toko') }}
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="nama_pegawai">Nama Pegawai :</label>
                <input type="text" wire:model="state.nama_pegawai" name="state.nama_pegawai" id="state.nama_pegawai" class="form-control form-control-sm {{ $errors->has('state.nama_pegawai') ? 'is-invalid':'' }}" placeholder="Masukan Nama Pegawai..." required>
                <div class="invalid-feedback">
                  {{ $errors->first('state.nama_pegawai') }}
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="email">Email Pegawai :</label>
                <input type="email" wire:model="state.email" name="state.email" id="state.email" class="form-control form-control-sm {{ $errors->has('state.email') ? 'is-invalid':'' }}" placeholder="Masukan Email...">
                <div class="invalid-feedback">
                  {{ $errors->first('state.email') }}
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="password">Password :</label>
                <input type="password" wire:model="state.password" name="state.password" id="state.password" class="form-control form-control-sm {{ $errors->has('state.password') ? 'is-invalid':'' }}" placeholder="Masukan Password...">
                <div class="invalid-feedback">
                  {{ $errors->first('state.password') }}
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password :</label>
                <input type="password" wire:model="state.password_confirmation" name="state.password_confirmation" id="state.password_confirmation" class="form-control form-control-sm {{ $errors->has('state.password_confirmation') ? 'is-invalid':'' }}" placeholder="Konfirmasi Ulang Password...">
                <div class="invalid-feedback">
                  {{ $errors->first('state.password_confirmation') }}
                </div>
              </div>
            </div>
            <div class="col-12">
              <hr class="mt-0">
            </div>
            <div class="col-md-3">
              <button class="btn btn-success btn-sm btn-block" wire:click="{{ $state['id'] != null ? 'updateData':'createData' }}">
                <i class="fa fa-plus"></i> &ensp; {{ $state['id'] != null ? 'Simpan Data':'Buat Data Pegawai' }}
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
          <h4 class="card-title"><i class="fa fa-user text-sm text-primary"></i> &ensp; Daftar Data Pegawai</h4>
          <div class="card-tools">
            <button class="btn btn-xs btn-outline-danger px-3" wire:click="$emitTo('component.modal-trashed-data', 'showModalTrashed', 'show')">
              <span class="fa fa-trash"></span> &ensp; Data Terhapus
            </button>
            <button class="btn btn-xs btn-success px-3" wire:click="showForm(true)">
              <span class="fa fa-plus"></span> &ensp; Tambah Data
            </button>
          </div>
        </div>
        <div class="card-body text-sm px-0 table-responsive">
          <table class="table table-bordered">
            <thead>
              <th class="align-middle p-2 text-center" width="10%">No.</th>
              <th class="align-middle p-2 text-center" width="15%">Toko</th>
              <th class="align-middle p-2">Nama Pegawai</th>
              <th class="align-middle p-2">Email</th>
              <th class="align-middle p-2 text-center" width="10%">#</th>
            </thead>
            <tbody>
              @forelse ($dataPegawai as $item)
                <tr>
                  <td class="align-middle py-1 px-2 text-center">{{ ($dataPegawai->currentpage()-1) * $dataPegawai->perpage() + $loop->index + 1 }}.</td>
                  <td class="align-middle py-1 px-2 text-center">{{ $item->toko->nama_toko }}</td>
                  <td class="align-middle py-1 px-2">{{ $item->nama_pegawai }}</td>
                  <td class="align-middle py-1 px-2">{{ $item->user->email }}</td>
                  <td class="align-middle py-1 px-2 text-center">
                    <div class="btn-group">
                      <button class="btn btn-info btn-xs px-3" wire:click="$emitTo('pegawai.modal-detail', 'openDetailModal', '{{ $item->id }}')">
                        <i class="fa fa-eye"></i>
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
      </div>
    </div>
  </div>
  @livewire('component.modal-trashed-data', ['modelName' => 'pegawai'])
  @livewire('pegawai.modal-detail')
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
        console.log($(this).val());
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