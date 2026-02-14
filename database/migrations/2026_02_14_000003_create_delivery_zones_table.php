<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('delivery_type', ['radius', 'polygon', 'postal_code']);
            $table->decimal('center_latitude', 10, 8)->nullable();
            $table->decimal('center_longitude', 11, 8)->nullable();
            $table->decimal('radius_km', 8, 2)->nullable();
            $table->json('polygon_coordinates')->nullable();
            $table->json('postal_codes')->nullable();
            $table->decimal('base_delivery_fee', 10, 2)->default(0);
            $table->decimal('per_km_fee', 8, 2)->default(0);
            $table->decimal('minimum_order_amount', 10, 2)->nullable();
            $table->decimal('free_delivery_threshold', 10, 2)->nullable();
            $table->decimal('maximum_delivery_distance', 8, 2)->nullable();
            $table->integer('estimated_delivery_time')->nullable()->comment('in minutes');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->json('extra_charges')->nullable();
            $table->json('working_hours')->nullable();
            $table->timestamps();

            $table->index('is_active');
            $table->index('is_default');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_zones');
    }
};
