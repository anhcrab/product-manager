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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained()->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('summary')->nullable();
            $table->string('detail')->nullable();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->integer('regular_price')->default(0);
            $table->integer('sale_price')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->bigInteger('total_sale')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
