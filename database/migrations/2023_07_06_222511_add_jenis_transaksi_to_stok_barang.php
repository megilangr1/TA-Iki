<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJenisTransaksiToStokBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stok_barangs', function (Blueprint $table) {
            $table->boolean('jenis_transaksi')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stok_barangs', function (Blueprint $table) {
            $table->dropColumn('jenis_transaksi');
        });
    }
}
