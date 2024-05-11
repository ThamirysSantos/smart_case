<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->string('name_client');
            $table->string('cpf', 11);
            $table->string('description');
            $table->integer('amount');
            $table->enum('status', array('PENDING', 'PAID', 'EXPIRED', 'FAILED'));
            $table->string('payment_method');
            $table->dateTime('paid_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
