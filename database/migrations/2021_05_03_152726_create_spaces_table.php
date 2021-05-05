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
            $table->string('code')
                ->unique()
                ->index()
                ->nullable();
            $table->foreignId('user_id')
                ->constrained('users', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->json('dimensions');
            $table->float('weight')->default(0);
            $table->text('note')->nullable();
            $table->integer('price')->default(0);
            $table->integer('tax')->default(0)->nullable();
            $table->string('type')->default('Local');
            $table->string('base');
            $table->datetime('reserved_at')->nullable();
            $table->datetime('departs_at');
            $table->datetime('arrives_at');
            $table->string('origin');
            $table->string('destination');
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
