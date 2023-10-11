<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKrsPegawaiTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krs_pegawai_template', function (Blueprint $table) {
            $table->id();
            $table->string('pegawaiID',50)->nullable();
            $table->string('nip',50)->nullable();
            $table->integer('thnpns')->nullable();
            $table->string('nama_lengkap',255)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('pendidikan',50)->nullable();
            $table->string('eselon',25)->nullable();
            $table->date('tmteselon')->nullable();
            $table->string('pangkat',255)->nullable();
            $table->string('golongan',50)->nullable();
            $table->date('tmtpangkat')->nullable();
            $table->string('level_jabatan',255)->nullable();
            $table->string('nama_jabatan',255)->nullable();
            $table->date('tmt_jabatan')->nullable();
            $table->date('satker')->nullable();
            $table->string('tipepegawai',255)->nullable();
            $table->string('statuspegawai',100)->nullable();
            $table->string('kedudukan',255)->nullable();
            $table->integer('id_krs')->nullable();
            $table->string('tahun_krs',5)->nullable();
            $table->string('jenis_krs',25)->nullable();
            $table->string('tahun_penkom',5)->nullable();
            $table->string('mansoskul',25)->nullable();
            $table->string('generik',25)->nullable();
            $table->string('spesifik',25)->nullable();
            $table->string('created_by',150)->nullable();
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
        Schema::dropIfExists('krs_pegawai_template');
    }
}
