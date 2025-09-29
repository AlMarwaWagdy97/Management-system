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
        Schema::create('badal_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('badal_id');
            $table->integer('rate');
            $table->string('description')->nullable();
            $table->tinyinteger('status')->default(1);

            $table->foreign('badal_id')->references('id')->on('badal_orders')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badal_reviews');
    }
};
