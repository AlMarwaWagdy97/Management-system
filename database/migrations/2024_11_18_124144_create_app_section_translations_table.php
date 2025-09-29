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
        Schema::create('app_section_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id');
            $table->string('locale')->index();
            
            $table->string('title');
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
            
            $table->unique(['section_id', 'locale']);
            $table->foreign('section_id')->references('id')->on('app_sections')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_section_translations');
    }
};
