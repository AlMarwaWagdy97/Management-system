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

        Schema::create('badal_offers', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->float('amount', 14, 2)->nullable();

            $table->foreignId('substitute_id')->nullable()->constrained('substitutes')->onDelete('cascade'); // Foreign key to users table, nullable
            $table->foreignId('badal_project_id')->nullable()->constrained('charity_badal_projects')->onDelete('cascade'); // Foreign key to users table, nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badal_offers');
    }
};
