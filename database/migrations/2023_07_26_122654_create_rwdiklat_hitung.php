<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRwdiklatHitung extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rwdiklat_hitung', function (Blueprint $table) {
            $table->id();
            $table->string('nip',50)->nullable();
            $table->string('diklat_teknis',250)->nullable();
            $table->integer('total_ds')->nullable();
            $table->string('diklat_struktural',50)->nullable();
            $table->string('created_by',250)->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('rwdiklat_hitung');
    }
}
