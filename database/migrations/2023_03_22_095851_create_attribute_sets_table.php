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
        Schema::create('attribute_sets', function (Blueprint $table) {
            $table->id();
            $table->enum('display_layout', ['virsual', 'text', 'dropdown'])->default('virsual')->comment("virsual, text,dropdown");
            $table->integer('sort')->nullable()->default(0);
            $table->tinyinteger('feature')->nullable()->default(1);
            $table->tinyInteger('status')->nullable()->default(1);
            $table->tinyInteger('is_searchable')->nullable()->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('attribute_sets');
    }
};
