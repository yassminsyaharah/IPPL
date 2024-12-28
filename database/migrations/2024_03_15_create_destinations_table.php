<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up () : void
    {
        Schema::create ( 'destinations', function (Blueprint $table)
        {
            $table->id ();
            $table->string ( 'name' );
            $table->text ( 'description' );
            $table->string ( 'address' );
            $table->string ( 'province' );
            $table->string ( 'operating_hours' );
            $table->string ( 'image_folder_path' )->nullable ();
            $table->decimal ( 'ratings', 2, 1 )->default ( 0.0 );
            $table->integer ( 'review_count' )->default ( 0 );
            $table->timestamps ();
        } );
    }

    public function down () : void
    {
        Schema::dropIfExists ( 'destinations' );
    }
};
