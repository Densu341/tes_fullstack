<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->create('cache', function (Blueprint $collection) {
            $collection->string('key')->unique(); // Unik, bukan primary
            $collection->string('value'); // mediumText diganti string
            $collection->integer('expiration');
        });

        Schema::connection('mongodb')->create('cache_locks', function (Blueprint $collection) {
            $collection->string('key')->unique();
            $collection->string('owner');
            $collection->integer('expiration');
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('cache');
        Schema::connection('mongodb')->dropIfExists('cache_locks');
    }
};
