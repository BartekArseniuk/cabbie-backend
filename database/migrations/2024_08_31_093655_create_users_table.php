<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('pesel')->nullable()->unique();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->enum('role', ['admin', 'client'])->default('client');
            $table->string('password');
            $table->string('verification_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_first_login')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}