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
            $table->char('uuid', 36)->unique();
            $table->string('type', 20);
            $table->string('name')->default('');
            $table->text('description')->nullable();
            $table->string('tags')->nullable();

            $table->string('url');
            $table->string('thumb_url');
            $table->boolean('is_public')->default(false);

            // Metadata
            $table->string('height', 12)->nullable();
            $table->string('width', 12)->nullable();
            $table->string('size', 20)->nullable();
            $table->string('iso', 15)->nullable();
            $table->string('aperture', 20)->nullable();
            $table->string('make', '50')->nullable();
            $table->string('model', '50')->nullable();
            $table->string('shutter', '30')->nullable();
            $table->string('focal', '20')->nullable();
            $table->string('takestamp', '12')->nullable();

            $table->char('album_id', 36)->nullable();
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
