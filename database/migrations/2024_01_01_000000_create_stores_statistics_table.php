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
        Schema::create('stores_statistics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id'); // This will be domain_id
            $table->string('store_name');
            $table->string('api_url')->nullable();
            $table->integer('orders_count')->default(0);
            $table->decimal('orders_total', 15, 2)->default(0);
            $table->integer('projects_count')->default(0);
            $table->integer('managers_count')->default(0);
            $table->integer('marketers_count')->default(0);
            $table->date('statistics_date');
            $table->timestamps();
            
            $table->index(['store_id', 'statistics_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores_statistics');
    }
};
