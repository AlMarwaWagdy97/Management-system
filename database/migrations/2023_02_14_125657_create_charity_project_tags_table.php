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
        Schema::create('charity_project_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->references('id')->on('charity_projects')->onDelete('cascade')->nullable();
            $table->foreignId('tag_id')->references('id')->on('charity_tags')->onDelete('cascade')->nullable();
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
        Schema::dropIfExists('charity_project_tags');
    }
};
