<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('first_name')->index();
            $table->string('last_name')->index();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable()->index();
            $table->string('citizenship')->nullable();
            $table->string('insurance')->nullable();
            $table->string('parent_first_name')->nullable();
            $table->string('parent_last_name')->nullable();
            $table->string('parent_personal_number')->nullable();
            $table->string('phone')->nullable()->index();
            $table->string('address')->nullable();
            $table->string('proficiency')->nullable()->index();
            $table->string('consultation_price')->nullable();
            $table->string('personal_number')->nullable()->unique();
            $table->string('referral_source')->nullable();
            $table->string('role')->index();
            $table->json('attached_files')->nullable();
            $table->string('remember_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
