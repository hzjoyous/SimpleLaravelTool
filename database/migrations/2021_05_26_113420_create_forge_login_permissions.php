<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForgeLoginPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forge_login_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')
                ->nullable(false)
                ->default('0')
                ->comment("用户ID");
            $table->unsignedBigInteger('sheet_id')
                ->nullable(false)
                ->default('0')
                ->comment("工单ID");
            $table->unsignedBigInteger('authorization_id')
                ->nullable(false)
                ->default('0')
                ->comment("授权id");
            $table->unsignedTinyInteger('status')
                ->nullable(false)
                ->default(1)
                ->comment('1待审核，2审核通过，3审核失败');
            $table->dateTime('expire_time')
                ->nullable(false)
                ->default('1970-01-01 01:01:01')
                ->comment('过期时间');
            $table->softDeletes();
            $table->timestamps();
            $table->index('user_id','idx_user_id');
            $table->index('sheet_id','idx_sheet_id');
            $table->index('authorization_id','idx_authorization_id');
            $table->index('expire_time','idx_expire_time');
            });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forge_login_permissions');
    }
}
