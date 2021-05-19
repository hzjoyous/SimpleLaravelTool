<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupIdToDouBanTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dou_ban_topics', function (Blueprint $table) {
            if (Schema::hasColumn('dou_ban_topics', 'group_id')) {
                dump("存在无需执行");
            } else {
                $table->string('group_id')->default(0);
                $table->index('group_id','index_group_id');
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
        Schema::table('dou_ban_topics', function (Blueprint $table) {
            //
        });
    }
}
