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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('overview');
            $table->string('poster_path')->nullable();
            $table->float('vote_average')->default(0);
            $table->date('release_date');
            $table->integer('runtime');
            $table->string('tagline')->nullable();
            // Genre tidak bisa dihapus jika masih dipakai movie
            $table->foreignId('genre_id')->constrained('genres')->restrictOnDelete();
            // User dihapus → movie ikut terhapus
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
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
        Schema::dropIfExists('movies');
    }
};
