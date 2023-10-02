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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal("stock_capacity_in_grams")->default(0);
            $table->decimal("available_quantity_in_grams")->default(0);
            $table->unsignedBigInteger("measurement_unit_id")->nullable();
            $table->foreign('measurement_unit_id')->references('id')->on('measurement_units')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
