<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->string('order_no')->index();
            $table->string('name', 200);
            $table->string('email', 200);
            $table->string('phone', 30);
            $table->text('address', 30);
            $table->smallInteger('qty');
            $table->float('lat', 10,6)->nullable();
            $table->float('lng', 10,6)->nullable();
            $table->string('location', 200)->nullable();
            $table->smallInteger('status')->default(1);
            $table->boolean('is_complete')->default(0);
            $table->date('completed_at')->nullable();
            $table->string('code', 60);
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
}
