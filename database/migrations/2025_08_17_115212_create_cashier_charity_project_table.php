<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashierCharityProjectTable extends Migration
{
    public function up()
    {
        Schema::create('cashier_charity_project', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cashier_id');
            $table->unsignedBigInteger('charity_project_id');
            $table->timestamps();

            $table->foreign('cashier_id')->references('id')->on('cashiers')->onDelete('cascade');
            $table->foreign('charity_project_id')->references('id')->on('charity_projects')->onDelete('cascade');
            $table->unique(['cashier_id', 'charity_project_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cashier_charity_project');
    }
}