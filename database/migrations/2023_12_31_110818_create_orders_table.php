<?php

use App\Enums\ShippingStatusEnum;
use App\Enums\SourcesEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique()->nullable();
            $table->double('total')->default(1);
            $table->integer('quantity')->default(1);
            $table->enum('source', SourcesEnum::values())->default(SourcesEnum::WEB);
            $table->unsignedBigInteger('donor_id')->nullable()->comment('donor_id if login');
            $table->unsignedBigInteger('refer_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->string('note')->nullable();
            $table->string('payment_method_key')->nullable();
            $table->text('payment_proof')->nullable()->comment('response the payment ');
            $table->string('banktransferproof')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('API_status')->nullable();
            $table->string('API_odoo')->nullable();
            $table->boolean('is_notified')->default(0);
            $table->tinyinteger('status')->default(0);
            $table->enum('shipping_status', ShippingStatusEnum::values())->default(ShippingStatusEnum::PENDING);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('donor_id')->references('id')->on('donors')->onDelete('cascade');
            $table->foreign('refer_id')->references('id')->on('refers')->onDelete('cascade');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
