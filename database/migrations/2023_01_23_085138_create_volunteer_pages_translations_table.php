<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteer_pages_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('VolunteerPage_id')->references('id')->on('volunteer_pages')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('slug')->nullable();
            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->longText('meta_key')->nullable();
            $table->unique(['VolunteerPage_id', 'locale']);
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
        Schema::dropIfExists('volunteer_pages_translations');
    }
};
