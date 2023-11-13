<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->string("nik");
            $table->date("tgl_presensi");
            $table->time("jam_in");
            $table->time("jam_out")->nullable();
            $table->string("foto_in");
            $table->string("foto_out")->nullable();
            $table->text("lokasi_in");
            $table->text("lokasi_out")->nullable();
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
        Schema::dropIfExists('presensis');
    }
};
