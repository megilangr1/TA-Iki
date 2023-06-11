<?php

namespace App\Http\Livewire\Component;

use App\Helper\DynamicModel;
use Livewire\Component;
use Livewire\WithPagination;

class ModalTrashedData extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $trashedData = [];
    public $model, $field;

    public $modalTitle = 'Data Terhapus';

    protected $listeners = [
        'showModalTrashed',
        'refreshData' => '$refresh'
    ];

    public function mount($modelName = null)
    {
        $helper = new DynamicModel;
        $this->model = $modelName;
        $this->field = $helper->modelField($this->model);

        $viewConf = $helper->pageConfig($this->model);
        $this->modalTitle = $viewConf['modal-title'] ?? $this->modalTitle;
    }
    
    public function render()
    {
        $helper = new DynamicModel;
        $model = $helper->modelVar($this->model);
        if ($model != false) {
            $getData = $model->onlyTrashed();
        
            $getData = $getData->orderBy('deleted_at', 'DESC')->paginate(5);
    
            $x = json_decode(json_encode($getData), true);
            if (count($x['data']) > 0) {
                foreach ($x['data'] as $key => $value) {
                    $this->trashedData[$value['id']] = $value;
                }
            } 
        }

        return view('livewire.component.modal-trashed-data', [
            'dataTrashed' => $getData,
        ]);
    }

    public function showModalTrashed($val)
    {
        $this->resetPage();

        $val = !in_array($val, ['show', 'hide']) ? 'show' : $val;
        $this->emit('modal-trashed-'. $this->model, $val);
    }
}
