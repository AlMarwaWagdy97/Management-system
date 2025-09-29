<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeToRefersTable extends Migration
{
    public function up()
    {
        Schema::table('refers', function (Blueprint $table) {
            $table->string('code', 6)->after('id');
        });
    }

    public function down()
    {
        Schema::table('refers', function (Blueprint $table) {
            $table->dropUnique(['code']);
            $table->dropColumn('code');
        });
    }
}

