<?php

namespace App\Helper;

use App\Models\Toko;

class DynamicModel 
{
  public function modelVar($name)
  {
    $model = null;
    switch ($name) {
      case 'toko':
        $model = new Toko();
        break;
      default:
        $model = false;
        break;
    }

    return $model;
  }

  public function modelField($name)
  {
    $field = [];
    switch ($name) {
      case 'toko':
        $field = [
          [
            'th' => 'Nama Toko',
            'th_class' => 'align-middle btw-1',
            'field_name' => 'nama_toko',
            'td_class' => 'align-middle font-weight-bold', 
            'type' => 'string',
          ],
          [
            'th' => 'Alamat Toko',
            'th_class' => 'align-middle btw-1',
            'field_name' => 'alamat_toko',
            'td_class' => 'align-middle font-weight-bold', 
            'type' => 'string',
          ],
          [
            'th' => 'Tanggal Hapus',
            'th_class' => 'align-middle btw-1 text-center',
            'field_name' => 'deleted_at',
            'td_class' => 'align-middle font-weight-bold text-center', 
            'type' => 'date',
          ],
        ];
        break;
      default:
        $field = [];
        break;
    }

    return $field;
  }

  public function pageConfig($name)
  {
    $viewConfig = null;
    switch ($name) {
      case 'satuan':
        $viewConfig = [
          'modal-title' => 'Satuan Terhapus', 
        ];
        break;
      default:
        $viewConfig = false;
        break;
    }

    return $viewConfig;
  }

}