<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferReferTable extends Migration
{
    public function up()
    {
        Schema::create('refer_refer', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('child_id');
            $table->primary(['parent_id','child_id']);
            $table->foreign('parent_id')->references('id')->on('refers')->onDelete('cascade');
            $table->foreign('child_id' )->references('id')->on('refers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('refer_refer');
    }
}
