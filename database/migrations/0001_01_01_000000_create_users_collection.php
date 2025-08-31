<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->create('users', function (Blueprint $collection) {
            $collection->string('name');
            $collection->string('email')->unique();
            $collection->timestamp('email_verified_at')->nullable();
            $collection->string('password');
            $collection->string('remember_token')->nullable();
            $collection->timestamps(); // created_at & updated_at
        });

        Schema::connection('mongodb')->create('password_reset_tokens', function (Blueprint $collection) {
            $collection->string('email')->unique();
            $collection->string('token');
            $collection->timestamp('created_at')->nullable();
        });

        Schema::connection('mongodb')->create('sessions', function (Blueprint $collection) {
            $collection->string('id')->primary(); // Bisa pakai string atau ObjectId
            $collection->string('user_id')->nullable()->index(); // Tidak pakai foreignId
            $collection->string('ip_address', 45)->nullable();
            $collection->string('user_agent')->nullable();
            $collection->longText('payload'); // Tetap bisa di Mongo
            $collection->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('users');
        Schema::connection('mongodb')->dropIfExists('password_reset_tokens');
        Schema::connection('mongodb')->dropIfExists('sessions');
    }
};
