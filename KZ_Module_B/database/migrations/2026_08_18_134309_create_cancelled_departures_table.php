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
        Schema::create('cancelled_departures', function (Blueprint $table) {
            $table->id();
            $table->string('departure_code')->unique();
            $table->foreignId('line_id')->constrained('lines')->cascadeOnDelete();
            $table->date('departure_date');
            $table->text('reason')->nullable();
            $table->timestamp('cancelled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancelled_departures');
    }
};
