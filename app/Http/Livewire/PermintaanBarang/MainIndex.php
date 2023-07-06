<?php

namespace App\Http\Livewire\PermintaanBarang;

use App\Models\PermintaanBarang;
use Livewire\Component;
use Livewire\WithPagination;

class MainIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $getData = PermintaanBarang::with('detail', 'toko', 'gudang', 'toko_tujuan', 'gudang_tujuan')->orderBy('created_at', 'ASC')->paginate('10');

        return view('livewire.permintaan-barang.main-index', [
            'dataPermintaan' => $getData
        ])->layout('backend.layouts.master');
    }

    public function deleteData($id)
    {
        DB::beginTransaction();
        try {
            $getData = PermintaanBarang::where('id', '=', $id)->firstOrFail();

            $deleteData = $getData->delete();
            $deleteDetail = $getData->detail()->delete();

            DB::commit();
            $this->emit('warning', 'Data di-Hapus !');
        } catch (\Exception $e) {
            DB::rollback();
            $this->emit('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Adminstrator !');
        }
    }
}
