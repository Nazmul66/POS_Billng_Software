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
        Schema::create('billing_pos', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->string('customer_name');
            $table->string('address');
            $table->string('contact_number');
            $table->string('engineer_name');
            $table->string('mechanic_name');
            $table->string('car_name');
            $table->string('registration_number');
            $table->string('chassis_number');
            $table->string('engine_number');
            $table->string('color');
            $table->text('products')->nullable();
            $table->text('services');
            $table->text('remarks')->nullable();
            $table->string('time_in');
            $table->string('time_out');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_pos');
    }
};
