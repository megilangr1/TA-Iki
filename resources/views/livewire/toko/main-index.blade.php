<div>
  <div class="row">
    <div class="col-12 {{ $form ? 'd-block':'d-none' }}">
      <div class="card card-outline card-success">
        <div class="card-header">
          <h4 class="card-title" wire:click="$refresh"><i class="fa fa-edit text-sm text-success"></i> &ensp; Tambah Data Toko </h4>
          <div class="card-tools">
            <button class="btn btn-xs btn-danger px-3" wire:click="showForm(false)">
              <i class="fa fa-times"></i> &ensp; Tutup Form 
            </button>
          </div>
        </div>
        <div class="card-body py-2 px-3 text-sm">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="nama_toko">Nama Toko : <i class="text-danger">*</i></label>
                <input type="text" wire:model="state.nama_toko" name="nama_toko" id="nama_toko" class="form-control form-control-sm {{ $errors->has('state.nama_toko') ? 'is-invalid':'' }}" placeholder="Masukan Nama Toko..." required>
                <div class="invalid-feedback">
                  {{ $errors->first('state.nama_toko') }}
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="alamat_toko">Alamat Toko : </label>
                <textarea wire:model="state.alamat_toko" name="alamat_toko" id="alamat_toko" cols="1" rows="1" class="form-control form-control-sm {{ $errors->has('state.alamat_toko') ? 'is-invalid':'' }}" placeholder="Masukan Alamat Toko..."></textarea>
                <div class="invalid-feedback">
                  {{ $errors->first('state.alamat_toko') }}
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
          <h4 class="card-title"><i class="fa fa-store text-sm text-primary"></i> &ensp; Daftar Data Toko</h4>
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
                <th class="align-middle p-2">Nama Toko</th>
                <th class="align-middle p-2">Alamat Toko</th>
                <th class="align-middle p-2 text-center" width="10%">#</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($dataToko as $item)
                <tr>
                  <td class="align-middle py-1 px-2 text-center">{{ ($dataToko->currentpage()-1) * $dataToko->perpage() + $loop->index + 1 }}.</td>
                  <td class="align-middle py-1 px-2">{{ $item->nama_toko }}</td>
                  <td class="align-middle py-1 px-2">{{ $item->alamat_toko != null ? $item->alamat_toko : '-' }}</td>
                  <td class="align-middle py-1 px-2 text-center">
                    <div class="btn-group">
                      <button class="btn btn-xs btn-warning px-2" wire:click="editData('{{ $item->id }}')">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-xs btn-danger px-2" wire:click="deleteData('{{ $item->id }}')">
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
                {{ $dataToko->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @livewire('component.modal-trashed-data', ['modelName' => 'toko'])
</div>
