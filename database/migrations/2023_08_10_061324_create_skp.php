<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talenta_skp', function (Blueprint $table) {
            $table->id();
            $table->string('pegawaiID',50)->nullable();
            $table->string('nip',50)->nullable();
            $table->string('nama',255)->nullable();
            $table->string('tahunPenilaian',5)->nullable();
            $table->string('tglPenilaian',25)->nullable();
            $table->integer('nourut')->nullable();
            $table->string('nilai_angka')->nullable();
            $table->integer('rangking')->nullable();
            $table->string('created_by',50)->nullable();
            $table->timestamps();
            $table->string('updated_by',50)->nullable();
            $table->index(['nip']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('talenta_skp');
    }
}
