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
        Schema::create('app_articles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('section_id');
            $table->integer('hits')->nullable()->default(0);
            $table->integer('sort')->nullable()->default(0);
            $table->string('image')->nullable();
            $table->tinyinteger('feature')->nullable()->default(1);
            $table->tinyInteger('status')->nullable()->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('section_id')->references('id')->on('app_sections')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_articles');
    }
};
