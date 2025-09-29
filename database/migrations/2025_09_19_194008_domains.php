<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('domain_name');
            $table->string('domain_url');
            $table->boolean('status')->default(false);
            $table->string('token')->nullable();
            $table->enum('type', ['zid','holol'])->comment('zid, holol');
            $table->timestamps();
            $table->unique(['domain_name']);
            $table->unique(['domain_url']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};