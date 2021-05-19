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
            $table->string('topic_id')->default(0);
            $table->string('group_id')->default(0);
            $table->string('user_id')->default(0);
            dump(
              <<<eof
SQLite允许向一个integer型字段中插入字符串
这是一个特性，而不是一个bug。SQLite不强制数据类型约束。任何数据都可以插入任何列。你可以向一个整型列中插入任意长度的字符串，向布尔型列中插入浮点数，或者向字符型列中插入日期型值。在CREATE TABLE中所指定的数据类型不会限制在该列中插入任何数据。任何列均可接受任意长度的字符串（只有一种情况除外：标志为INTEGER PRIMARY KEY的列只能存储64位整数，当向这种列中插数据除整数以外的数据时，将会产生错误。
但SQLite确实使用声明的列类型来指示你所期望的格式。所以，例如你向一个整型列中插入字符串时，SQLite会试图将该字符串转换成一个整数。如果可以转换，它将插入该整数；否则，将插入字符串。这种特性有时被称为类型或列亲和性(type or column affinity).
eof
            );
            $table->index('topic_id','index_topic_id');
            $table->index('group_id','index_group_id');
            $table->index('user_id','index_user_id');
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
