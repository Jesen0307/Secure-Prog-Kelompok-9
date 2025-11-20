<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Basic info
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Profile fields
            $table->string('profile_photo')->nullable(); // path foto profil (disimpan di storage)
            $table->text('bio')->nullable();             // deskripsi atau bio singkat

            // Wallet balance (e-commerce specific)
            $table->decimal('wallet_balance', 15, 2)->default(0);

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
