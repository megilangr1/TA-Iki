<?php

namespace App\Http\Livewire\PengirimanBarang;

use App\Models\PengirimanBarang;
use Livewire\Component;
use Livewire\WithPagination;

class ModalData extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'openModalDataPengiriman',
    ];

    public function render()
    {
        $getData = PengirimanBarang::with([
            'toko',
            'gudang',
        ])
        ->withCount('detail')
        ->where('status', '=', 1)
        ->orderBy('tanggal_pengiriman', 'DESC')->paginate(5);

        return view('livewire.pengiriman-barang.modal-data', [
            'dataPengiriman' => $getData
        ]);
    }

    public function openModalDataPengiriman($data)
    {
        if ($data != null) {
            $showProps = $data['props'] ?? 'hide';

            $this->emit('modal-data-pengiriman', $showProps);
        }
    }

    public function selectPengirimanBarang($id)
    {
        if ($id != null) {
            try {
                $getData = PengirimanBarang::with([
                    'toko',
                    'gudang',
                    'toko_tujuan',
                    'gudang_tujuan',
                    'detail',
                    'detail.barang'
                ])->where('id', '=', $id)->firstOrFail();

                $this->emit('modal-data-pengiriman', 'hide');
                $this->emitUp('selectedPengirimanBarang', $getData->toArray());
            } catch (\Exception $e) {
                dd($e);
            }
        }
    }
}
