<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');

            $table->foreign('product_id')
            ->references('id')
            ->on('products')
            ->onDelete('cascade');

            $table->unsignedBigInteger('sale_id');

            $table->foreign('sale_id')
            ->references('id')
            ->on('sales')
            ->onDelete('cascade');

            $table->integer('product_amount');
            $table->decimal('price_per_unit', 12, 4);

            $table->decimal('subtotal', 12, 4);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_item');
    }
};
