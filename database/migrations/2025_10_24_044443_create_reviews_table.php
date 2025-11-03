<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->string('review_id')->unique();
            $table->string('reviewer_name')->nullable();
            $table->text('comment')->nullable();
            $table->unsignedTinyInteger('star_rating')->nullable();
            $table->timestamp('create_time')->nullable();
            $table->timestamp('update_time')->nullable();
            $table->json('raw_data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('reviews');
    }
};
