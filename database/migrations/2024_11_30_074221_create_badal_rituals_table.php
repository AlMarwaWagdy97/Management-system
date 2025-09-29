<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('badal_rituals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('substitute_id');
            $table->unsignedBigInteger('rite_id');

            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('proof')->nullable()->comment('url for video');

            $table->boolean('start')->default(0);
            $table->timestamp('start_time')->nullable();
            $table->boolean('complete')->default(0);

            $table->tinyinteger('status')->default(1);

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('charity_projects')->onDelete('cascade');
            $table->foreign('substitute_id')->references('id')->on('substitutes')->onDelete('cascade');
            $table->foreign('rite_id')->references('id')->on('badal_rites')->onDelete('cascade');

            $table->softDeletes();        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badal_rituals');
    }
};
