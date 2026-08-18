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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code', 10)->unique();
            $table->string('departure_code');
            $table->foreignId('line_id')->constrained('lines');
            $table->date('departure_date');
            $table->time('departure_time');
            $table->string('first_name', 60);
            $table->string('last_name', 60);
            $table->string('email');
            $table->string('phone')->nullable();
            $table->unsignedSmallInteger('seats');
            $table->decimal('fare_cny', 5, 2);
            $table->enum('status', ['confirmed', 'cancelled'])->default('confirmed');
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
