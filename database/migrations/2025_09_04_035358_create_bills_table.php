<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('bills', function (Blueprint $table) {
        $table->id();
        $table->string('invoice_number')->unique();
        $table->foreignId('client_id')->constrained()->onDelete('cascade');
        $table->decimal('total', 10, 2);
        $table->decimal('cash_given', 10, 2)->default(0);
        $table->decimal('balance', 10, 2)->default(0);
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
