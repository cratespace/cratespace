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
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('space_id')->constrained('spaces');
            $table->string('status')->default('Pending');
            $table->string('confirmation_number')
                ->unique()
                ->nullable()
                ->index();
            $table->string('name')->index();
            $table->string('email')->index();
            $table->string('phone', 50)->index();
            $table->string('business')->nullable();
            $table->integer('service');
            $table->integer('price');
            $table->integer('subtotal');
            $table->integer('tax');
            $table->integer('total');
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
