<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    public function up()
{
    if (!Schema::hasTable('staff')) {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_number', 15);
            $table->integer('ratings')->default(0);
            $table->timestamps();
        });
    }
}

public function down()
{
    Schema::dropIfExists('staff');
}
}