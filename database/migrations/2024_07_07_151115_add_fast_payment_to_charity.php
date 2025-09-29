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
       
        Schema::table('category_projects', function (Blueprint $table) {
            $table->tinyinteger('fast_donation')->default(0)->after('status');
        });


        Schema::table('charity_projects', function (Blueprint $table) {
            $table->tinyinteger('fast_donation')->default(0)->after('sort');
            $table->tinyinteger('is_gift')->default(0)->after('fast_donation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('charity', function (Blueprint $table) {
            //
        });
    }
};
