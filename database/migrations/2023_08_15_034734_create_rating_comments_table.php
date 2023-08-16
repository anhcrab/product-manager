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
        Schema::create('rating_comments', function (Blueprint $table) {
            $table->id();
            $table->string('device')->unique();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->integer('rating_star')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating_comments');
    }
};
