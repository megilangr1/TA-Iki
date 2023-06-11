<?php

namespace App\Helper;

use App\Models\Barang;
use App\Models\Kategori;
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
      case 'kategori':
        $model = new Kategori();
        break;
      case 'barang':
        $model = new Barang();
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
      case 'kategori':
        $field = [
          [
            'th' => 'Nama Kategori',
            'th_class' => 'align-middle btw-1',
            'field_name' => 'nama_kategori',
            'td_class' => 'align-middle font-weight-bold', 
            'type' => 'string',
          ],
          [
            'th' => 'Keterangan',
            'th_class' => 'align-middle btw-1',
            'field_name' => 'keterangan',
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
      case 'barang':
        $field = [
          [
            'th' => 'Nama Barang',
            'th_class' => 'align-middle btw-1',
            'field_name' => 'nama_barang',
            'td_class' => 'align-middle font-weight-bold', 
            'type' => 'string',
          ],
          [
            'th' => 'Keterangan',
            'th_class' => 'align-middle btw-1',
            'field_name' => 'keterangan',
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
      case 'toko':
        $viewConfig = [
          'modal-title' => 'Toko Terhapus', 
        ];
        break;
      case 'kategori':
        $viewConfig = [
          'modal-title' => 'Kategori Terhapus', 
        ];
        break;
      case 'barang':
        $viewConfig = [
          'modal-title' => 'Barang Terhapus', 
        ];
        break;
      default:
        $viewConfig = false;
        break;
    }

    return $viewConfig;
  }

}