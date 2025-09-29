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
        Schema::create('menues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->enum('position',['main', 'footer', 'side'])->default('main')->comment("main, footer,side");
            $table->integer('sort')->nullable()->default(0);
            $table->string('url')->nullable();
            $table->string('type')->default('static')->nullable();
            $table->string('dynamic_table')->nullable();
            $table->string('dynamic_url')->nullable();
            $table->integer('level')->nullable();
            $table->tinyinteger('status')->nullable()->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();        
            $table->timestamps();
        });


        Schema::table('menues',function (Blueprint $table){
            $table->foreign('parent_id')->references('id')->on('menues')->nullable()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menues');
    }
};
