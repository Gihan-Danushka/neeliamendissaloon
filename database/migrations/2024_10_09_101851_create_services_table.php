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
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name'); // Service name
            $table->decimal('price', 8, 2); // Price with precision
            $table->enum('gender', ['Male', 'Female', 'Both'])->default('Both');
            $table->string('description')->nullable(); // Description (optional)
            $table->string('service_image')->nullable(); // Service image (optional)
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Delete services if category is deleted
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
