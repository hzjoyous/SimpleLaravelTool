<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewServer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yxzx_new_server', function (Blueprint $table) {
            $table->id('id');
            $table->string('game_code')->nullable(false)->default('')->comment("游戏编号");
            $table->string('game_server_name')->nullable(false)->default('')->comment("游戏服务器名称");
            $table->integer('weight')->nullable(false)->default(0)->comment("权重");
            $table->dateTime('open_time')
                ->nullable(false)
                ->default('2000-01-01 01:01:01')
                ->comment('开服时间');
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
        Schema::dropIfExists('yxzx_new_server');
    }
}
