<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenkom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penkom', function (Blueprint $table) {
            $table->id();
            $table->string('nip',50)->nullable();
            $table->string('nama',250)->nullable();
            $table->string('jenis',50)->nullable();
            $table->string('tahun',8)->nullable();
            $table->string('pangkat',250)->nullable();
            $table->string('golongan',25)->nullable();
            $table->string('jabatan',250)->nullable();
            $table->text('unit_kerja')->nullable();
            $table->integer('mansoskul')->nullable()->default('0');
            $table->integer('teknis_generik')->nullable()->default('0');
            $table->integer('teknis_spesifik')->nullable()->default('0');
            $table->string('hashname',250)->nullable();
            $table->string('created_by',50)->nullable();
            $table->timestamps();
            $table->string('updated_by',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penkom');
    }
}
