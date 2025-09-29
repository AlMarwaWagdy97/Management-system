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
        Schema::create('gift_occasioins_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('occasioin_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->unique(['occasioin_id', 'locale']);
            $table->foreign('occasioin_id')->references('id')->on('gift_occasioins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_occasioins_translations');
    }
};
