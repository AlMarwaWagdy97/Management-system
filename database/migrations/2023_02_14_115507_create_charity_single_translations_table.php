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
        Schema::create('charity_single_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('single_id');
            $table->string('locale')->index();
            $table->string('gift_title')->nullable();
            $table->unique(['single_id', 'locale']);
            $table->foreign('single_id')->references('id')->on('charity_single_projects')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charity_single_translations');
    }
};
