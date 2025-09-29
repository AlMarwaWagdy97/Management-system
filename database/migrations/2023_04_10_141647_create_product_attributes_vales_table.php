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
        Schema::create('product_attributes_vales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('variance_id');
            $table->unsignedBigInteger('attribute_value_id');

            $table->foreign('variance_id')->references('id')->on('product_variances')->onDelete('cascade');
            $table->foreign('attribute_value_id')->references('id')->on('attributes')->onDelete('cascade');
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
        Schema::dropIfExists('product_attributes_vales');
    }
};
