<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talenta_users', function (Blueprint $table) {
            $table->id();
            $table->string('userid')->unique();
            $table->string('name',255)->nullable();
            $table->string('email',100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',255);
            $table->integer('id_akses')->nullable;
            $table->integer('isActive')->nullable;
            $table->rememberToken();
            $table->string('created_by',200)->nullable();
            $table->timestamps();
            $table->string('modified_by',200)->nullable();
            $table->index(['userid','name','password','isActive','id_akses']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('talenta_users');
    }
}
