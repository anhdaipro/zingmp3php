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
        Schema::create('post_medias', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->foreignId('post_id')
            ->constrained('posts')
            ->onUpdate('cascade')
            ->onDelete('cascade');
           
            $table->string('file');
            $table->string('file_preview')->nullable();
            $table->float('duration')->default(0)->nullable();
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
        Schema::dropIfExists('post_medias');
    }
};
