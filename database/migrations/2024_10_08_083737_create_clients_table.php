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
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name'); // Client name
            $table->string('email')->nullable();
            $table->unique('email');// Client email
            $table->string('contact'); // Contact phone number
            $table->string('address'); // Address
            $table->string('whatsapp'); // WhatsApp number
            $table->string('allergies')->nullable(); // allergies
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
