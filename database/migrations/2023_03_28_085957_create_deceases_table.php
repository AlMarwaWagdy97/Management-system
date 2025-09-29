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
        Schema::create('deceases', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('image')->nullable();
            $table->float('target_price')->nullable();
            $table->longText('description')->nullable();
            $table->string('deceased_name')->nullable();
            $table->string('relative_relation')->nullable();
            $table->string('deceased_image')->nullable();
            $table->tinyInteger('confirm_mobile')->default(1)->nullable();
            $table->tinyInteger('status')->default(1)->nullable();
            $table->tinyInteger('confirmed')->default(0)->nullable();
            $table->foreignId('project_id')->references('id')->on('charity_projects')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('deceases');
    }
};
