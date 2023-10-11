<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRwjabatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rwjabatan', function (Blueprint $table) {
            $table->id();
            $table->string('nip',50)->nullable();
            $table->string('nama',255)->nullable();
            $table->string('eselon',50)->nullable();
            $table->string('tmteselon',15)->nullable();
            $table->string('namajabatan',255)->nullable();
            $table->string('tmtjabatan',15)->nullable();
            $table->string('tglsk',50)->nullable();
            $table->text('satker')->nullable();
            $table->string('nourut',50)->nullable();
            $table->string('created_by',50)->nullable();
            $table->timestamps();
            $table->string('updated_by',50)->nullable();
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
        Schema::dropIfExists('rwjabatan');
    }
}
