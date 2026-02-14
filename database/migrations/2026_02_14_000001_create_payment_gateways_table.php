<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('type', ['card', 'bank', 'mobile_money', 'wallet', 'crypto']);
            $table->text('description')->nullable();
            $table->text('api_key')->nullable();
            $table->text('api_secret')->nullable();
            $table->text('merchant_id')->nullable();
            $table->text('public_key')->nullable();
            $table->text('private_key')->nullable();
            $table->string('webhook_url')->nullable();
            $table->string('callback_url')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_test_mode')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('supported_currencies')->nullable();
            $table->decimal('exchange_rate', 10, 2)->nullable();
            $table->decimal('fixed_charge', 10, 2)->default(0);
            $table->decimal('percentage_charge', 5, 2)->default(0);
            $table->string('country')->nullable();
            $table->string('default_currency')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
