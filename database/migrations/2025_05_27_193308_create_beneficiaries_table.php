<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('beneficiaries', function (Blueprint $table) {
    $table->id();
    $table->foreignId('account_id')->constrained()->onDelete('cascade');
    $table->string('first_name');
    $table->string('middle_name');
    $table->string('last_name');
    $table->string('gender');
    $table->string('nationality');
    $table->string('marital_status');
    $table->string('phone');
    $table->date('date_of_birth');
    $table->string('family_members');
    $table->string('education_level');
    $table->string('city');
    $table->string('district');
    $table->string('id_number');
    $table->string('civil_register');
    $table->string('email');
    $table->string('housing_status');
    $table->string('job_type')->nullable();
    $table->string('monthly_income');
    $table->string('previous_registration');
    $table->string('chronic_diseases');
    $table->string('special_needs');
    $table->text('other_income')->nullable();
    $table->text('additional_notes')->nullable();
    $table->boolean('status')->default(0);
    $table->unsignedBigInteger('created_by')->nullable();
    $table->unsignedBigInteger('updated_by')->nullable();
    $table->softDeletes();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
