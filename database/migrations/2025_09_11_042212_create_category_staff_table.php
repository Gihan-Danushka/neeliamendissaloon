<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryStaffTable extends Migration
{
    public function up()
{
    if (!Schema::hasTable('category_staff')) {
        Schema::create('category_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }
}

public function down()
{
    Schema::dropIfExists('category_staff');
}
}