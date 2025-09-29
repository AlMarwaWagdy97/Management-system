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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('order_details_id');
            $table->string('item_type')->comment('model name that will load from');
            $table->unsignedBigInteger('item_id')->comment('model item id like project id or product id');
            $table->string('item_name')->nullable()->comment('item title');
            $table->string('item_sub_type')->nullable()->comment('like donation type or occasion name');
            $table->integer('quantity')->default(1);
            $table->double('price')->default(1);
            $table->double('total')->default(1);
            $table->boolean('is_gift')->default(0);
            // shipping_status	enum('pending', 'picking', 'picked', 'delivering',...	utf8mb4_unicode_ci		Yes	pending
            $table->enum('shipping_status', ['pending','picking','picked','delivering','delivered','canceled'])->default('pending')->comment('pending, picking, picked, delivering, delivered, canceled');
            $table->integer('rate')->nullable();
            $table->string('review')->nullable();
            $table->json('gift_details')->nullable()->comment('image that will sent to giver and note for message etc');
            $table->unsignedBigInteger('vendor_id')->nullable()->comment('vendor id if type is product');
            $table->tinyinteger('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            // $table->foreign('giver_id')->references('id')->on('givers')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
