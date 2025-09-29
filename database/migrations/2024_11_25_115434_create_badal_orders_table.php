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
        Schema::create('badal_orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('substitute_id')->nullable();
            $table->unsignedBigInteger('project_id');
            
            $table->tinyinteger('is_offer')->default(0);
            $table->unsignedBigInteger('offer_id')->nullable();

            $table->string('behafeof')->nullable();
            $table->string('relation')->nullable();
            $table->string('language')->nullable();
            $table->string('gender')->nullable();

            $table->timestamp('start_at')->nullable();
            $table->timestamp('complete_at')->nullable();

            $table->tinyinteger('status')->default(0);
            
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('substitute_id')->references('id')->on('substitutes')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('charity_projects')->onDelete('cascade');
            $table->foreign('offer_id')->references('id')->on('badal_offers')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badal_orders');
    }
};
