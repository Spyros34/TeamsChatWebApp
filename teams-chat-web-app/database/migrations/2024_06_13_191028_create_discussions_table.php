<?php

// database/migrations/xxxx_xx_xx_create_discussions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscussionsTable extends Migration
{
    public function up()
    {
        Schema::create('tblDiscussion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IDUserFrom');
            $table->unsignedBigInteger('IDUserTo');
            $table->text('ChatText');
            $table->timestamp('Datetime');
            $table->foreign('IDUserFrom')->references('id')->on('tbluser')->onDelete('cascade');
            $table->foreign('IDUserTo')->references('id')->on('tbluser')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tblDiscussion');
    }
}