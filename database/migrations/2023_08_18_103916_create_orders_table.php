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
        $payment_method = ['cod', 'banking', 'at_store'];
        $shipping_method = ['express', 'saving', 'fast'];
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid();
            $table->longText('products');
            $table->decimal('total_price');
            $table->unsignedInteger('user_device');
            $table->String('user_id')->nullable();
            $table->text('address');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->foreignId('payment_method_id')->constrained()->cascadeOnDelete();
            $table->foreignId('shipping_method_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
