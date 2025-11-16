<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {

            // PK autoincrement 
            $table->increments('order_id');

            $table->string('customer_name', 255);
            $table->decimal('total_amount', 10, 2);
            $table->string('status', 20)->default('pending');

            $table->timestamp('created')->useCurrent();
            $table->unsignedBigInteger('created_by')->default(0);

            $table->timestamp('updated')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedBigInteger('updated_by')->default(0);

            $table->unsignedTinyInteger('is_deleted')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
