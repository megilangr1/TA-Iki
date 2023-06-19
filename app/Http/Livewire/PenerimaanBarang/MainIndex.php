<?php

namespace App\Http\Livewire\PenerimaanBarang;

use App\Models\PenerimaanBarang;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MainIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $getData = PenerimaanBarang::with('detail')->orderBy('created_at', 'ASC')->paginate('10');

        return view('livewire.penerimaan-barang.main-index', [
            'dataPenerimaan' => $getData
        ])->layout('backend.layouts.master');
    }

    public function deleteData($id)
    {
        DB::beginTransaction();
        try {
            $getData = PenerimaanBarang::where('id', '=', $id)->firstOrFail();

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
