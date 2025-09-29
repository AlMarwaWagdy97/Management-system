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
        Schema::create('file_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('filename')->nullable();
            $table->string('path')->nullable();
            $table->string('mime_type')->nullable();
            $table->float('size')->nullable();
            $table->string('description')->nullable();
            $table->string('linked_model')->nullable();
            $table->string('linked_model_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_uploads');
    }
};
