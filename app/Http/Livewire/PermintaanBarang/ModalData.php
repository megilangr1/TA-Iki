<?php

namespace App\Http\Livewire\PermintaanBarang;

use App\Models\PermintaanBarang;
use Livewire\Component;
use Livewire\WithPagination;

class ModalData extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'openModalDataPermintaan',
    ];

    public function render()
    {
        $getData = PermintaanBarang::with([
            'toko',
            'gudang',
        ])
        ->withCount('detail')
        ->orderBy('tanggal_permintaan', 'DESC')->paginate(5);

        return view('livewire.permintaan-barang.modal-data', [
            'dataPermintaan' => $getData
        ]);
    }

    public function openModalDataPermintaan($data)
    {
        if ($data != null) {
            $showProps = $data['props'] ?? 'hide';

            $this->emit('modal-data-permintaan', $showProps);
        }
    }

    public function selectPermintaanBarang($id)
    {
        if ($id != null) {
            try {
                $getData = PermintaanBarang::with([
                    'toko',
                    'gudang',
                    'toko_tujuan',
                    'gudang_tujuan',
                    'detail',
                    'detail.barang'
                ])->where('id', '=', $id)->firstOrFail();


                $this->emit('modal-data-permintaan', 'hide');
                $this->emitUp('selectedPermintaanBarang', $getData->toArray());
            } catch (\Exception $e) {
                dd($e);
            }
        }
    }
}
