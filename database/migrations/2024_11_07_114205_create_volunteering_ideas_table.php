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
        Schema::create('volunteering_ideas', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('subject')->nullable();
            $table->text('message')->nullable();
            $table->integer('sort')->nullable()->default(0);
            $table->tinyinteger('status')->default(0);
                        
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteering_ideas');
    }
};
