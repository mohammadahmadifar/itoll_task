<?php

use App\Models\Order\Order;
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

            $table->point('location_receive');
            $table->string('address_receive');
            $table->foreignId('user_id')->constrained();
            $table->string('name_sender');
            $table->string('mobile_sender');
            $table->point('location_delivery');
            $table->string('address_delivery');
            $table->string('name_delivery');
            $table->string('mobile_delivery');
            $table->foreignId('driver_id')->nullable()->references('id')->on('users');
            $table->enum('status', Order::$statuses)->comment(implode(',', Order::$statuses));
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
