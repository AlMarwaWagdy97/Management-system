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
    Schema::table('refers', function (Blueprint $table) {
        $table->boolean('is_group_manager')->default(false)->after('status');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('refers', function (Blueprint $table) {
        $table->dropColumn('is_group_manager');
    });
}
};
