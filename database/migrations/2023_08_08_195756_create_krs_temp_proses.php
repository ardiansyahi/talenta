<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKrsTempProses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krs_temp_proses', function (Blueprint $table) {
            $table->id();
            $table->integer('id_krs')->nullable();
            $table->string('jenis',25)->nullable();
            $table->string('nip',50)->nullable();
            $table->string('nama',255)->nullable();
            $table->string('tgl_lahir',25)->nullable();
            $table->string('pendidikan',25)->nullable();
            $table->string('eselon',100)->nullable();
            $table->string('level_jabatan',255)->nullable();
            $table->string('provinsi',255)->nullable();
            $table->text('satker')->nullable();
            $table->string('nama_jabatan',255)->nullable();
            $table->string('tmt_jabatan',25)->nullable();
            $table->string('pangkat',150)->nullable();
            $table->string('golongan',25)->nullable();
            $table->string('cek_penkom',150)->nullable();
            $table->string('skoring_mansoskul',3)->nullable();
            $table->string('skoring_generik',3)->nullable();
            $table->string('skoring_spesifik',3)->nullable();
            $table->string('skoring_pendidikan',3)->nullable();
            $table->string('total_rw_jabatan',3)->nullable();
            $table->string('bobot_rw_jabatan',3)->nullable();
            $table->double('bobot_rw_jabatan_total')->nullable();
            $table->string('diklat_struktural',25)->nullable();
            $table->string('bobot_ds',3)->nullable();
            $table->string('diklat_teknis',3)->nullable();
            $table->string('bobot_dt',3)->nullable();
            $table->string('total_bobot',10)->nullable();
            $table->double('total_bobot_persen')->nullable();
            $table->string('skoring_pangkat')->nullable();
            $table->string('year2')->nullable();
            $table->string('year1')->nullable();
            $table->double('penilaian_perilaku')->nullable();
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
        Schema::dropIfExists('krs_temp_proses');
    }
}
