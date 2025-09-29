<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('sort')->nullable();
            $table->float('price')->nullable();
            $table->float('vendor_price')->nullable();
            $table->string('sku')->nullable();
            $table->text('image')->nullable();
            $table->string('cover_image')->nullable();

            $table->string('quantity')->nullable();
            $table->string('start_at')->nullable();
            $table->string('end_at')->nullable();
            $table->float('sale_price')->nullable();


            $table->tinyInteger('is_variance')->nullable()->default(0);
            $table->tinyInteger('feature')->nullable();
            $table->tinyInteger('is_cheacked')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->enum('status', ['published', 'draft', 'pending', 'approved','unpublished','review','rejected'])->default('unpublished')->comment("pulished, draft,pending,approved,upublished,review,rejected");

            $table->foreignId('vendor_id')->references('id')->on('vendors')->onDelete('cascade')->nullable();
            $table->foreignId('category_id')->references('id')->on('product_categories')->onDelete('cascade')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
