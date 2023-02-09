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
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            //user doing the following, it is creeating colum and key(we know table and column and reference ) 
            $table->foreignId('user_id')->constrained();
            //user being follow, in this case we need to create the column and key by itself
            //first it is the column, second it is the key
            $table->unsignedBigInteger('followeduser')->constrained();
            $table->foreign('followeduser')->references('id')->on('users');
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
        Schema::dropIfExists('follows');
    }
};
