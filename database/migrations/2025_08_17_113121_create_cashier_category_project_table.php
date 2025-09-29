<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashierCategoryProjectTable extends Migration
{
    public function up()
    {
        Schema::create('cashier_category_project', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cashier_id');
            $table->unsignedBigInteger('category_project_id');
            $table->timestamps();

            $table->foreign('cashier_id')->references('id')->on('cashiers')->onDelete('cascade');
            $table->foreign('category_project_id')->references('id')->on('category_projects')->onDelete('cascade');
            $table->unique(['cashier_id', 'category_project_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cashier_category_project');
    }
}