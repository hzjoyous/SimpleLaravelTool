<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yxzx_coupon', function (Blueprint $table) {
//            $table->charset = 'gbk';
//            $table->collation = 'gbk_chinese_ci';
            $table->bigIncrements('id');
            $table->bigInteger('passid')
                ->default(0)
                ->comment('所属人id');
            $table->bigInteger('coupon_rule_id')
                ->default(0)
                ->comment('规则id');
            $table->unsignedTinyInteger('status')
                ->nullable(false)
                ->default(1)
                ->comment('1待使用，2使用中，3，已使用');
            $table->decimal('amount',10,2)
                ->nullable(false)
                ->default(0)
                ->comment('代金券金额');
            $table->dateTime('expire_time')
                ->nullable(false)
                ->default('1970-01-01 01:01:01')
                ->comment('过期时间');
            $table->dateTime('ctime')
                ->nullable(false)
                ->useCurrent()
                ->comment('创建时间');
            $table->dateTime('mtime')
                ->nullable(false)
                ->useCurrent()
                ->useCurrentOnUpdate()
                ->comment('创建时间');
            $table->index('passid', 'idx_passid');
            $table->index('coupon_rule_id', 'idx_coupon_rule_id');

//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yxzx_coupon');
    }
}
