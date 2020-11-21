<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreignId('stock_id');
            $table->unsignedBigInteger('price');
            $table->boolean('available');
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('CASCADE');

            $table->foreign('stock_id')
                ->references('id')
                ->on('stock')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('histories');
    }
}
