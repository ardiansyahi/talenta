<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKrs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krs', function (Blueprint $table) {
            $table->id();
            $table->string('tahun',4)->nullable();
            $table->integer('batch')->nullable();
            $table->string('jenis',15)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('created_by',100)->nullable();
            $table->integer('id_tikpot')->nullable();
            $table->integer('id_krs_awal')->nullable();
            $table->string('fileupload',255)->nullable();
            $table->string('status',15)->nullable();
            $table->timestamps();
            $table->string('updated_by',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return voids
     */
    public function down()
    {
        Schema::dropIfExists('krs');
    }
}
