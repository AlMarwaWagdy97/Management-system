<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('donation_settings', function (Blueprint $table) {
        $table->id();
        $table->float('sender_x_percent')->default(10); 
        $table->float('sender_y_percent')->default(20); 
        $table->float('recipient_x_percent')->default(10);
        $table->float('recipient_y_percent')->default(80); 
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_settings');
    }
};
