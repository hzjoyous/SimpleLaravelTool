<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDouBanCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dou_ban_comments', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->default('0');
            $table->string('topic_id')->default(0);
            $table->string('comment_id')->default(0);
            $table->text('comment');


            $table->timestamp('insert_at',0);
            $table->timestamps();

            $table->index('user_id','index_user_id');
            $table->index('topic_id','index_topic_id');
            $table->index('comment_id','index_comment_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dou_ban_comments');
    }
}
