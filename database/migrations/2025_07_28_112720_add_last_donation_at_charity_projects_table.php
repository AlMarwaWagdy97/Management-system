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
        Schema::table('charity_projects', function (Blueprint $table) {
             $table->string('donations_count')->nullable();
             $table->string('visits_count')->nullable();
             $table->timestamp('last_donation_at')->nullable();
             $table->boolean('statistic_status')->default(0)->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('charity_project', function (Blueprint $table) {
            //
        });
    }
};
