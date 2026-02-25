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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the service
            $table->decimal('price', 8, 2); // Price with precision
            $table->string('color')->nullable(); // Nullable color
            $table->string('colorCode')->nullable(); // Nullable color code
            $table->decimal('percentage')->nullable(); // Nullable percentage
            $table->date('reminding_date')->nullable(); // Date for reminding
            $table->unsignedBigInteger('invoice_id'); // Foreign key for invoices
            $table->timestamps();
    
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
