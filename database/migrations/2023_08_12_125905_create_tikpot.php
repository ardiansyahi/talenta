<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTikpot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talenta_tikpot', function (Blueprint $table) {
            $table->id();
            $table->string('nama',255)->nullable();
            $table->string('status',1)->nullable();
            $table->string('created_by',255)->nullable();
            $table->timestamps();
            $table->string('modified_by',255)->nullable();
        });

        Schema::create('talenta_tikpot_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_master');
            $table->string('nama',255)->nullable();
            $table->integer('min_potensial')->nullable();
            $table->integer('max_potensial')->nullable();
            $table->integer('min_kinerja')->nullable();
            $table->integer('max_kinerja')->nullable();
            $table->string('warna',25)->nullable();
            $table->integer('nourut')->nullable();
            $table->timestamps();
            $table->foreign('id_master')->references('id')->on('tikpot')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('talenta_tikpot_detail',function(Blueprint $table){
            $table->dropForeign('tikpot_detail_id_master_foreign');
            $table->dropIndex('tikpot_detail_id_master_index');
            $table->dropColumn('id_master');
        });
        Schema::dropIfExists('talenta_tikpot');

    }
}
