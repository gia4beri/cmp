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
        Schema::create('invoices', function (Blueprint $table){
            $table->id();
            $table->json('items');
            $table->double('total');
            $table->double('discount')->nullable();
            $table->integer('user_id')->index();
            $table->boolean('status')->default(false);
            $table->string('payment_method');
            $table->string('insurance')->nullable();
            $table->string('insurance_code')->nullable();
            $table->text('additional_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
