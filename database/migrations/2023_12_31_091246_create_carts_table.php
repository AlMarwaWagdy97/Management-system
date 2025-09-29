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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('item_type')->comment('model name of the item like (projects, product, card, etc)');
            $table->unsignedBigInteger('item_id');
            $table->string('item_sub_type')->nullable()->comment('shred donation name or unit name or gift detail or card occasion');
            $table->string('item_name')->nullable()->comment('item title');
            $table->string('cookeries')->nullable();
            $table->integer('quantity')->default(1);
            $table->double('price')->default(1);
            $table->unsignedBigInteger('cart_id')->nullable();
            $table->json('gift_details')->nullable()->comment('image that will sent to giver and note for message etc');
            $table->json('giften_details')->nullable()->comment('given data details');
            $table->json('gift_card_details')->nullable()->comment('gift card details');
            $table->json('gift_products_details')->nullable()->comment('gift products details');
            $table->json('gift_projects_details')->nullable()->comment('gift projects details');
            $table->unsignedBigInteger('donor_id')->nullable()->comment('donor_id if login');
            $table->unsignedBigInteger('vendor_id')->nullable()->comment('vendor id if type is product');
            // $table->unsignedBigInteger('refer_id')->nullable();
            $table->softDeletes(); 
            $table->timestamps();


            $table->foreign('donor_id')->references('id')->on('donors')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            // $table->foreign('refer_id')->references('id')->on('refers')->onDelete('cascade');
        });
   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
