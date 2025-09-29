<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToVolunteersTable extends Migration
{
    public function up()
    {
        Schema::table('volunteers', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable();
            $table->string('educational_qualification')->nullable();
            $table->json('preferred_fields')->nullable();
            $table->json('preferred_times')->nullable();
            $table->text('goal')->nullable();
        });
    }

    public function down()
    {
        Schema::table('volunteers', function (Blueprint $table) {
            $table->dropColumn(['date_of_birth', 'educational_qualification', 'preferred_fields', 'preferred_times', 'goal']);
        });
    }
}