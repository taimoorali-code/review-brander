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
    Schema::create('platforms', function (Blueprint $table) {
        $table->id();
        $table->foreignId('business_id')->constrained()->onDelete('cascade');
        $table->string('name'); // e.g. Google My Business
        $table->string('email')->nullable(); // the Gmail or account email
        $table->enum('status', ['connected', 'disconnected'])->default('disconnected');
        $table->timestamp('connected_on')->nullable();
        $table->json('credentials')->nullable(); // for tokens or API keys (future use)
        $table->json('extra_data')->nullable(); // for tokens or API keys (future use)
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platforms');
    }
};
