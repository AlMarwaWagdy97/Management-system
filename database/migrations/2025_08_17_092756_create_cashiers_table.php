<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashiersTable extends Migration
{
    public function up()
    {
        Schema::create('cashiers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id')->nullable()->index();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile')->nullable()->unique();
            $table->string('password');
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cashiers');
    }
}
