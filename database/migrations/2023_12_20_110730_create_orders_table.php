<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ShipmentStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained('users');
            $table->bigInteger('product_amount');
            $table->decimal('total_price',10,2);
            $table->enum('shipment_status',ShipmentStatus::toValues())->default(ShipmentStatus::ORDER_RECEIVED);
            $table->foreignId('address_id')->index()->constrained('addresses');
            $table->foreignId('invoice_address_id')->index()->constrained('addresses');
            $table->decimal('shipping_cost', 10, 2);
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
