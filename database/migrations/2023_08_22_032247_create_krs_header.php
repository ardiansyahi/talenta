<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKrsHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talenta_krs_header', function (Blueprint $table) {
            $table->id();
            $table->integer('id_krs')->nullable();
            $table->longText('pegawai')->nullable();
            $table->longText('potensial')->nullable();
            $table->longText('kinerja')->nullable();
            $table->longText('header')->nullable();
            $table->string('created_by',200)->nullable();
            $table->timestamps();
        });

        Schema::create('talenta_krs_bobot', function (Blueprint $table) {
            $table->id();
            $table->integer('id_krs')->nullable();
            $table->longText('jenis')->nullable();
            $table->longText('potensial')->nullable();
            $table->longText('kinerja')->nullable();
            $table->string('created_by',200)->nullable();
            $table->timestamps();
        });

        Schema::create('talenta_krs_final', function (Blueprint $table) {
            $table->id();
            $table->integer('id_krs')->nullable();
            $table->string('nip')->nullable();
            $table->longText('jenis')->nullable();
            $table->longText('pegawai')->nullable();
            $table->longText('potensial')->nullable();
            $table->longText('kinerja')->nullable();
            $table->longText('nilai')->nullable();
            $table->string('status',15)->nullable();
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
        Schema::dropIfExists('talenta_krs_header');
        Schema::dropIfExists('talenta_krs_bobot');
        Schema::dropIfExists('talenta_krs_final');
    }
}
