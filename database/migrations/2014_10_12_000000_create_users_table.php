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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'eleveur', 'collecteur', 'industrie', 'distributeur']);
            $table->string('country')->default('Tunisie');
            $table->string('state')->default('');
            $table->string('city')->default('');
            $table->string('address')->default('');
            $table->boolean('active')->default(false);
            $table->smallInteger('phase')->default(1);
            $table->string('company')->default('');
            $table->rememberToken();
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
