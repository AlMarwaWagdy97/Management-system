<?php

use App\Models\Settings;
use App\Models\SettingsValues;
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
        Schema::create('settings_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('setting_id')->nullable();
            $table->string('key')->nullable();
            $table->longText('value')->nullable();
            $table->tinyInteger('type',false,true)->default(0)->comment("0=>text , 1=>image, 2=>textarea, 3=>frame, 4=>textarea with line, 5=>number");
            $table->timestamps();
            $table->foreign('setting_id')->references('id')->on('settings')->onDelete('cascade');

        });

      

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings_values');
    }
};
