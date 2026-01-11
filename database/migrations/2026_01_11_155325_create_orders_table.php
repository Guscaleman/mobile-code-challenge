<?php

use App\Constants\Table;
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
        Schema::create(Table::ORDERS, function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->date('order_date');
            $table->date('delivered_at')->nullable();
            $table->enum('status', ['pendente', 'entregue', 'cancelado'])->default('pendente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Table::ORDERS);
    }
};
