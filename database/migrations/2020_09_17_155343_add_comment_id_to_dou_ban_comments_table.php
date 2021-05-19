<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentIdToDouBanCommentsTable extends Migration
{
    /**
     * php artisan make:migration add_group_id_to_dou_ban_topics_table --table=dou_ban_topics
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dou_ban_comments', function (Blueprint $table) {
            if (Schema::hasColumn('dou_ban_comments', 'comment_id')) {
                dump("存在无需执行");
            } else {
                $table->string('comment_id')->default(0);
                $table->index('comment_id','index_comment_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dou_ban_comments', function (Blueprint $table) {
            //
        });
    }
}
