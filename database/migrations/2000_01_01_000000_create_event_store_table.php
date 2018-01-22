<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_store', function (Blueprint $table) {
            $table->increments('id');
            $table->char('uuid', 36);
            $table->integer('playhead')->unsigned();
            $table->text('metadata');
            $table->text('payload');
            $table->string('recorded_on', 32);
            $table->text('type');
            $table->unique(['uuid', 'playhead']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_store');
    }
}
