<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ritestranslations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rites_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->unique(['rites_id', 'locale']);
            // $table->foreign('rites_id')->references('id')->on('rites')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ritestranslations');
    }
};
