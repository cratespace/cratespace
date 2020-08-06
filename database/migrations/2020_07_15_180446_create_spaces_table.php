<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spaces', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique()->index();
            $table->datetime('departs_at');
            $table->datetime('arrives_at');
            $table->string('origin');
            $table->string('destination');
            $table->float('height');
            $table->float('width');
            $table->float('length');
            $table->float('weight');
            $table->text('note')->nullable();
            $table->integer('price')->default(0);
            $table->integer('tax')->default(0);
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('type')->default('Local');
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
        Schema::dropIfExists('spaces');
    }
}
