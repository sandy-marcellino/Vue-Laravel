<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrasiDataPaket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_paket', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->string('pribadi');
            $table->string('terpisah');
            $table->string('detergen');
            $table->string('setrika');
            $table->string('ongkir');
            $table->integer('waktu');
            $table->integer('harga');
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
        Schema::dropIfExists('data_paket');
    }
}
