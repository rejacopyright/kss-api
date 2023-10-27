<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $address = collect(['address' => '', 'city_id' => '', 'prov_id' => '', 'lat' => '', 'long' => '',]);
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) use ($address) {
            $table->uuid('id')->primary();
            // $table->uuid('user_id')->nullable();
            $table->integer('role_id')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('name')->nullable();
            $table->string('ic_card')->nullable();
            $table->string('ic_no')->nullable()->comment('Identity Card Number');
            $table->timestamp('birth')->nullable();
            $table->jsonb('address')->nullable()->default($address);
            $table->integer('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('wa')->nullable();
            $table->string('avatar')->nullable();
            $table->string('status')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('api_token')->nullable();
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
};
