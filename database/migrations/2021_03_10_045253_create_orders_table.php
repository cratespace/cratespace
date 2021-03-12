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
            $table->foreignId('space_id')->constrained('spaces');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('customer_id')->constrained('users');
            $table->unsignedBigInteger('confirmation_number')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('business')->nullable();
            $table->unsignedInteger('price');
            $table->unsignedInteger('tax')->nullable();
            $table->unsignedInteger('total');
            $table->text('note')->nullable();
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
