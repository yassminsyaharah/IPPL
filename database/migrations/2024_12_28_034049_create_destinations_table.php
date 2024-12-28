<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up () : void
    {
        Schema::create ( 'destinations', function (Blueprint $table)
        {
            $table->id ();
            $table->string ( 'name' );
            $table->text ( 'description' );
            $table->string ( 'address' );
            $table->string ( 'province' );
            $table->time ( 'opening_hour' )->nullable ();
            $table->time ( 'closing_hour' )->nullable ();
            $table->string ( 'photo_folder' )->nullable ();
            // $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps ();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down () : void
    {
        Schema::dropIfExists ( 'destinations' );
    }
};
