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
        Schema::create('badal_rites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->references('id')->on('charity_projects')->onDelete('cascade');
            $table->integer('sort')->nullable();
            $table->integer('taken_time')->nullable();
            $table->tinyInteger('proof')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->text('image')->nullable();
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
        Schema::dropIfExists('rites');
    }
};
