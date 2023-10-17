<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKrsPegawaiTempAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talenta_krs_pegawai_temp_admin', function (Blueprint $table) {
            $table->id();
            $table->integer('id_krs')->nullable();
            $table->integer('id_krs_awal')->nullable();
            $table->string('nip')->nullable();
            $table->longText('jenis')->nullable();
            $table->longText('pegawai')->nullable();
            $table->string('nomor_surat_usul',100)->nullable();
            $table->string('tgl_surat',35)->nullable();
            $table->string('gelombang_1',100)->nullable();
            $table->string('dicalonkan_gelombang_2',255)->nullable();
            $table->string('kotak_talent_pool',25)->nullable();
            $table->longText('potensial')->nullable();
            $table->longText('kinerja')->nullable();
            $table->longText('nilai')->nullable();
            $table->string('created_by',200)->nullable();
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
        Schema::dropIfExists('talenta_krs_pegawai_temp_admin');
    }
}
