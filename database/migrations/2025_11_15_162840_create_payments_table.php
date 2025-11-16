<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {

            // PK autoincrement
            $table->increments('payment_id');

            // FK
            $table->unsignedInteger('order_id');
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');

            $table->decimal('amount', 10, 2);
            $table->string('status', 20);
            $table->string('external_transaction_id', 255)->nullable();

            $table->timestamp('created')->useCurrent();
            $table->unsignedBigInteger('created_by')->default(0);

            $table->timestamp('updated')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedBigInteger('updated_by')->default(0);

            $table->unsignedTinyInteger('is_deleted')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
