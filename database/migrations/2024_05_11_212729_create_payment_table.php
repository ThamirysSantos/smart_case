<?php

use App\Util\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('merchant_id');
            $table->string('name');
            $table->string('cpf', 11);
            $table->string('description');
            $table->float('amount');
            $table->enum('status', StatusEnum::toArray());
            $table->string('payment_method');
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();

            $table->foreign('merchant_id')->references('id')->on('merchant');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
