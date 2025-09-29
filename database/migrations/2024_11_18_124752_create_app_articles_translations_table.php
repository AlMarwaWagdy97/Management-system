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
        Schema::create('app_articles_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');
            $table->string('locale')->index();
            
            $table->string('title');
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
            
            $table->unique(['article_id', 'locale']);
            $table->foreign('article_id')->references('id')->on('app_sections')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_articles_translations');
    }
};
