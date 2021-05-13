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
            $table->string('code')
                ->unique()
                ->index()
                ->nullable();
            $table->string('payment')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('customer_id')->constrained('users');
            $table->unsignedBigInteger('confirmation_number')->nullable()->unique();
            $table->unsignedBigInteger('orderable_id')->index();
            $table->string('orderable_type', 50);
            $table->unsignedInteger('amount');
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
