<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrlkonfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talenta_urlkonfig', function (Blueprint $table) {
            $table->id();
            $table->text('url')->nullable();
            $table->integer('port')->nullable();
            $table->string('jenis',25)->nullable();
            $table->string('method',10)->nullable();
            $table->string('uid',255)->nullable();
            $table->string('pass',50)->nullable();
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
        Schema::dropIfExists('talenta_urlkonfig');
    }
}
