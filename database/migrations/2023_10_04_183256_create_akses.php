<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akses', function (Blueprint $table) {
            $table->id();
            $table->string('nama',250)->nullable();
            $table->text('id_form')->nullable();
            $table->integer('isdeleted')->nullable();
            $table->string('created_by',200)->nullable();
            $table->timestamps();
            $table->string('modified_by',200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akses');
    }
}
