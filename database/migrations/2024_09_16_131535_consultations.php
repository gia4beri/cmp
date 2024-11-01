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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->text('patient_complaints')->nullable();
            $table->text('examination_description')->nullable();
            $table->string('saturation');
            $table->string('temperature');
            $table->string('weight')->nullable();
            $table->string('pressure');
            $table->string('height')->nullable();
            $table->text('icd_code');
            $table->text('recommendations_prescription');
            $table->string('additional_information')->nullable();
            $table->string('final_prescription');
            $table->integer('user_id')->index();
            $table->integer('doctor_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
