<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblDiscussionTable extends Migration
{
    public function up()
    {
        Schema::create('tblDiscussion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_from_id');
            $table->unsignedBigInteger('user_to_id');
            $table->text('chat_text');
            $table->timestamp('datetime')->useCurrent();
            $table->timestamps();

            $table->index('user_from_id');
            $table->index('user_to_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tblDiscussion');
    }
}