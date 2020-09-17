<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentIdToDouBanCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dou_ban_comments', function (Blueprint $table) {
//            if (Schema::hasTable('users')) {      #如果不存在'users'表则执行
//            }
            if (Schema::hasColumn('dou_ban_comments', 'comment_id')) {    #如果不存在'users','email'列则执行
                $table->bigInteger('comment_id')->default(0);
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
