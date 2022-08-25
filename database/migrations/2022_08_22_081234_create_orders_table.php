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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->enum('shipping', ['NOSHIPPING','SHIPPING']);

            $table->text('invoice_address_title');
            $table->text('invoice_zip_code');
            $table->text('invoice_city');
            $table->text('invoice_address');

            $table->text('shipping_address_title');
            $table->text('shipping_zip_code');
            $table->text('shipping_city');
            $table->text('shipping_address');

            $table->enum('status', ['NEW','COMPLETED'])->default('NEW');

            $table->float('total')->nullable();

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
        Schema::dropIfExists('orders');
    }
};
