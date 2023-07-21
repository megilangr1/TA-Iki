<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_pos');
            $table->unsignedInteger('id_barang');
            $table->double('jumlah');
            $table->double('harga');
            $table->double('sub_total');
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
        Schema::dropIfExists('pos_details');
    }
}
