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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('image')->nullable();
            $table->integer('sort')->nullable()->default(0);
            $table->tinyinteger('status')->nullable()->default(1);
            $table->tinyinteger('feature')->nullable()->default(1);
            $table->tinyinteger('news_ticker')->nullable()->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->nullable();
            $table->softDeletes();        
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
        Schema::dropIfExists('articles');
    }
};
