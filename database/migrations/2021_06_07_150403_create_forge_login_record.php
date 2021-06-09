<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForgeLoginRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forge_login_record', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(false)->default(0)->comment("申请用户ID");
            $table->unsignedBigInteger('auth_id')->nullable(false)->default(0)->comment("目标ID");
            $table->string('access_token',1024)->default('');
            $table->string('refresh_token',1024)->default('');
            $table->softDeletes();
            $table->timestamps();
            $table->index('user_id','idx_user_id');
            $table->index('user_id','idx_auth_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forge_login_record');
    }
}
