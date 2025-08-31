<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mongodb')->create('jobs', function (Blueprint $collection) {
            $collection->string('queue')->index();
            $collection->string('payload'); // longText -> string
            $collection->integer('attempts');
            $collection->integer('reserved_at')->nullable();
            $collection->integer('available_at');
            $collection->integer('created_at');
        });

        Schema::connection('mongodb')->create('job_batches', function (Blueprint $collection) {
            $collection->string('name');
            $collection->integer('total_jobs');
            $collection->integer('pending_jobs');
            $collection->integer('failed_jobs');
            $collection->string('failed_job_ids'); // longText -> string
            $collection->string('options')->nullable(); // mediumText -> string
            $collection->integer('cancelled_at')->nullable();
            $collection->integer('created_at');
            $collection->integer('finished_at')->nullable();
        });

        Schema::connection('mongodb')->create('failed_jobs', function (Blueprint $collection) {
            $collection->string('uuid')->unique();
            $collection->string('connection');
            $collection->string('queue');
            $collection->string('payload'); // longText -> string
            $collection->string('exception'); // longText -> string
            $collection->timestamp('failed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('jobs');
        Schema::connection('mongodb')->dropIfExists('job_batches');
        Schema::connection('mongodb')->dropIfExists('failed_jobs');
    }
};
