<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRwjabatanHitung extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talenta_rwjabatan_hitung', function (Blueprint $table) {
            $table->id();
            $table->string('nip',50)->nullable();
            $table->string('nama',255)->nullable();
            $table->integer('total')->nullable();
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
        Schema::dropIfExists('talenta_rwjabatan_hitung');
    }
}
