<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 20);
            $table->string('name')->default('');
            $table->text('description')->nullable();
            $table->string('url');
            $table->string('thumb_url');
            $table->boolean('is_public')->default(false);

            // Metadata
            $table->text('metadata')->nullable;
            /*$table->string('height', 12);
            $table->string('width', 12);
            $table->string('size', 20);
            $table->string('height', 10);
            $table->string('height', 10);
            $table->string('iso', 15);
            $table->string('aperture', 20);
            $table->string('make', '50');
            $table->string('model', '50');
            $table->string('shutter', '30');
            $table->string('focal', '20');
            $table->string('takestamp', '12');*/

            $table->text('tags')->nullable();
            $table->integer('album_id')->unsigned()->nullable();
            $table->char('checksum', 40)->nullable();
            $table->timestamps();

            $table->foreign('album_id')
                ->references('id')
                ->on('albums')
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
        Schema::dropIfExists('photos');
    }
}
