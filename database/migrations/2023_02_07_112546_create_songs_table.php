<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->string('image_cover')->nullable();
            $table->string('file');
            $table->float('duration');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('album_id')->nullable()->constrained('albums')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('genre_id')->nullable()->constrained('genres')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('mv_id')->nullable()->constrained('mvs')->onDelete('cascade')->onUpdate('cascade');
            $table->string('artist_name');
            $table->boolean('hasLyric')->default(false);
            $table->json('lyrics')->nullable();
            $table->boolean('hasKaraoke')->default(false);
            $table->json('sentences')->nullable();
            $table->integer('country')->default(1);
            $table->integer('viewer')->default(1);
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
        Schema::dropIfExists('songs');
        
    }
};
