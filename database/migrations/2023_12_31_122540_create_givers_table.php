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
        Schema::create('givers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('occasioin_id')->nullable();
            $table->string('group')->nullable();
            $table->string('image')->nullable();
            $table->string('category_name')->nullable();
            $table->string('occasioin_name')->nullable();
            $table->string('card_id')->nullable();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('message')->nullable();
            $table->tinyinteger('status')->default(1);
            $table->softDeletes(); 
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('order_details')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('gift_categories')->onDelete('cascade');
            $table->foreign('occasioin_id')->references('id')->on('gift_occasioins')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('givers');
    }
};
