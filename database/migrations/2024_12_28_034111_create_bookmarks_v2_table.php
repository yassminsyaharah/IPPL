<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bookmarks_v2', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('place_id'); // Google Places ID
            $table->timestamps();
            
            // Prevent duplicate bookmarks
            $table->unique(['user_id', 'place_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookmarks_v2');
    }
};
