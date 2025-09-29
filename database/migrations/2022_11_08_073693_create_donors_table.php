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
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('refer_id')->nullable();
            $table->string('full_name');
            $table->string('identity')->nullable();
            $table->string('mobile')->nullable();
            $table->tinyinteger('mobile_confirm')->default('1');
            $table->integer('otp')->nullable();
            $table->string('token')->nullable();
            $table->string('image')->nullable();
            $table->integer('expiration')->nullable();
            $table->tinyinteger('status')->nullable()->default('1');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('refer_id')->references('id')->on('refers')->onDelete('cascade');
        });
        // $P$BPNAU..arf.SRaG3YYdz0f5bJ1Ymh.0
    }



    /**$P$BPNAU..arf.SRaG3YYdz0f5bJ1Ymh.0
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donors');
    }
};
