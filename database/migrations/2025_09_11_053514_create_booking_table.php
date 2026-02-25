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
        if (Schema::hasTable('bookings')) {
            return;
        }

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Assuming there is a users table
            $table->date('date');
            $table->decimal('total_price', 10, 2);
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->foreignId('staff_id')->nullable()->constrained('staff')->onDelete('set null');
            $table->enum('status', ['pending', 'rejected', 'approved', 'completed'])->default('pending');
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
