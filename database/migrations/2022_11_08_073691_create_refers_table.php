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
        Schema::create('refers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->string('slug');
            $table->string('name');
            $table->string('employee_name')->nullable();
            $table->string('employee_number')->nullable();
            $table->string('employee_image')->nullable();
            $table->string('employee_department')->nullable();
            $table->string('ax_store_name')->nullable();
            $table->string('job')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('location')->nullable();
            $table->string('details')->nullable();
            $table->tinyinteger('status')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refers');
    }
};
