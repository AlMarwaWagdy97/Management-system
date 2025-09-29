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
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('donor_id')->nullable();
            $table->string('name');
            $table->string('number');
            $table->string('expired_month');
            $table->string('expired_year');
            $table->string('merchant_reference')->nullable();
            $table->string('token_name')->nullable();
            $table->string('default')->default(0);
            $table->tinyinteger('status')->default(0);

            $table->softDeletes(); 
            $table->timestamps();

            $table->foreign('donor_id')->references('id')->on('donors')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_cards');
    }
};
