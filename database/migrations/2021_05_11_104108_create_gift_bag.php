<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftBag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yxzx_gift_bag', function (Blueprint $table) {
            $table->id('id');
            $table->string('game_code')->nullable(false)->default('')->comment("游戏编号");
            $table->integer('weight')->nullable(false)->default(0)->comment("权重");
            $table->string('gift_name')->nullable(false)->default("游戏昵称")->comment("游戏昵称");
            $table->text('gift_content')->comment("礼包内容");
            $table->text('introduction_to_use')->comment("如何使用");
            $table->string('cdk')->nullable()->default("");
            $table->unsignedTinyInteger('show_in_list')
                ->nullable(false)
                ->default(0)
                ->comment('是否在列表中展示，0:不展示，1：展示');
            $table->dateTime('start_time')
                ->nullable(false)
                ->default('2000-01-01 01:01:01')
                ->comment('生效时间');
            $table->dateTime('end_time')
                ->nullable(false)
                ->default('2000-01-01 01:01:01')
                ->comment('生效结束时间');
            $table->dateTime('ctime')
                ->nullable(false)
                ->useCurrent()
                ->comment('创建时间');
            $table->dateTime('mtime')
                ->nullable(false)
                ->useCurrent()
                ->useCurrentOnUpdate()
                ->comment('创建时间');
            $table->index('game_code','index_game_code');
            $table->index('weight','index_weight');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yxzx_gift_bag');
    }
}
