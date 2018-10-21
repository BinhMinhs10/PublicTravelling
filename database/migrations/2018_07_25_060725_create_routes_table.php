<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('plan_id');
            $table->datetime('starting_time');
            $table->float('start_latitude', 18, 14);
            $table->float('start_longitude', 18, 14);
            $table->datetime('finish_time');
            $table->float('finish_latitude', 18, 14)->nullable();
            $table->float('finish_longitude', 18, 14)->nullable();
            $table->string('activities');
            $table->string('vehicle')->nullable();
            $table->integer('no');
            $table->timestamps();

            // foreign key
            $table->foreign('plan_id')
                ->references('id')->on('plans')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('routes');
    }
}
