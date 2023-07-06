<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermintaanBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permintaan_barangs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_toko');
            $table->unsignedBigInteger('id_gudang');

            $table->unsignedBigInteger('id_toko_tujuan');
            $table->unsignedBigInteger('id_gudang_tujuan');

            $table->date('tanggal_permintaan');
            $table->text('keterangan')->nullable();
            $table->boolean('status')->default(false);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permintaan_barangs');
    }
}
