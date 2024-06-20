<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddForeignKeysToTblDiscussionTable extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE tblDiscussion ADD CONSTRAINT FK_user_from_id FOREIGN KEY (user_from_id) REFERENCES tbluser(id) ON DELETE NO ACTION');
        DB::statement('ALTER TABLE tblDiscussion ADD CONSTRAINT FK_user_to_id FOREIGN KEY (user_to_id) REFERENCES tbluser(id) ON DELETE NO ACTION');
    }

    public function down()
    {
        DB::statement('ALTER TABLE tblDiscussion DROP CONSTRAINT FK_user_from_id');
        DB::statement('ALTER TABLE tblDiscussion DROP CONSTRAINT FK_user_to_id');
    }
}