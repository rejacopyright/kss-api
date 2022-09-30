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
        Schema::dropIfExists('admin');
        Schema::create('admin', function (Blueprint $table) use ($address) {
            $table->uuid('id')->primary();
            // $table->uuid('admin_id')->nullable();
            $table->integer('role_id')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('password')->nullable();
            // https://stackoverflow.com/questions/71135857/laravel-forgot-and-reset-password-api-with-jwt-authentication
            $table->longText('password_reset_token')->nullable();
            $table->timestamp('password_reset_created')->nullable();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('admin');
    }
};
