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
        Schema::table('volunteers', function (Blueprint $table) {
            $table->enum('type', ['volunteer', 'team'])->default('volunteer')->nullable()->after('id');
            $table->string('team_logo')->nullable()->after('image');
            $table->string('team_name')->nullable()->after('gender');
            $table->string('password')->nullable()->after('email');
            $table->integer('effective')->default(0)->nullable()->after('team_name');
            $table->integer('working_hours')->default(0)->nullable()->after('team_name');
            $table->string('medal')->nullable()->after('team_name');
            
            $table->unsignedBigInteger('account_id')->after('id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voluntreer', function (Blueprint $table) {
            //
        });
    }
};
