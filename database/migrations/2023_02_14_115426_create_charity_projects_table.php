<?php

use App\Enums\ProjectTypesEnum;
use App\Enums\LocationTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charity_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->references('id')->on('category_projects')->onDelete('cascade')->nullable();
            $table->enum('project_types', ProjectTypesEnum::values())->default(ProjectTypesEnum::NORMAL);
            $table->enum('location_type', LocationTypeEnum::values())->default(LocationTypeEnum::WEB);
            $table->string('number')->nullable();
            $table->string('beneficiary')->nullable();
            $table->tinyinteger('status')->nullable();
            $table->boolean('featuer')->default(false);
            $table->boolean('finished')->default(false);
            $table->boolean('recurring')->default(false);
            $table->integer('sort')->nullable();
            $table->longText('donation_type')->nullable();
            $table->integer('target_price')->nullable();
            $table->string('target_unit')->nullable();
            $table->integer('fake_target')->nullable();
            $table->integer('collected_target')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->longText('images')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('background_image')->nullable();
            $table->string('background_color')->nullable();
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
        Schema::dropIfExists('charity_projects');
    }
};
