<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDouBanTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dou_ban_topics', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('topic_id');
            $table->bigInteger('user_id');
            $table->string('topic_title');
            $table->text('topic_content');
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
        Schema::dropIfExists('dou_ban_topics');
    }
}
