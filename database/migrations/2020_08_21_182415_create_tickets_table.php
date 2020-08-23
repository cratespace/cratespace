<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->index();
            $table->string('subject');
            $table->string('status')->default('Open'); // Open, Closed
            $table->string('priority')->default('Low'); // Low, Medium, High
            $table->text('message')->nullable();
            $table->text('attachment')->nullable();
            $table->foreignId('customer_id')
                ->constrained('customers');
            $table->foreignId('agent_id')
                ->nullable()
                ->constrained('users');
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
        Schema::dropIfExists('tickets');
    }
}
