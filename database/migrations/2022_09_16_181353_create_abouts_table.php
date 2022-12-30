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
        Schema::create('about', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('active')->nullable()->default(1);
            $table->integer('index')->nullable()->default(0);
            $table->string('scope')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->jsonb('files')->nullable()->default(collect(['index' => '', 'name' => '', 'file' => '']));
            $table->string('parent')->nullable();
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
        Schema::dropIfExists('about');
    }
};
