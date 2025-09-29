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
        if (!Schema::hasColumn('category_projects', 'cashier_system')) {
            Schema::table('category_projects', function (Blueprint $table) {
                $table->boolean('cashier_system')->default(false)->after('fast_donation');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('category_projects', 'cashier_system')) {
            Schema::table('category_projects', function (Blueprint $table) {
                $table->dropColumn('cashier_system');
            });
        }
    }
};
