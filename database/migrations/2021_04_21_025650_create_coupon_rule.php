<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponRule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yxzx_coupon_rule', function (Blueprint $table) {
            $table->charset = 'gbk';
            $table->collation = 'gbk_chinese_ci';
            $table->bigIncrements('id');
            $table->string('name', 64)
                ->nullable(false)
                ->default('代金券')
                ->comment('代金券规则名称');
            $table->unsignedTinyInteger('type')
                ->nullable(false)
                ->default(1)
                ->comment('代金券规:满减:[full_reduction:1],直减:[direct_reduction:2]');
            $table->decimal('initial_amount',10,2)
                ->nullable(false)
                ->default(0)
                ->comment('代金券初试金额');
            $table->decimal('min_order_price',10,2)
                ->nullable(false)
                ->default(100000.00)
                ->comment('代金券最小支付订单');
            $table->bigInteger('effective_time')
                ->nullable(false)
                ->default(0)
                ->comment('发放之后有效时间有效时间');
            $table->dateTime('unified_expiration_time')
                ->nullable(false)
                ->default('2099-01-01 01:01:01')
                ->comment('统一有效时间，超过该日期，所有该规则下的代金券全部失效');
            $table->unsignedTinyInteger('use_complex_expiration_rule')
                ->nullable(false)
                ->default(0)
                ->comment('是否使用复杂过期规则');
            $table->text('complex_expiration_rule')
                ->nullable(true)
                ->comment('复杂过期规则');
            $table->dateTime('ctime')
                ->nullable(false)
                ->useCurrent()
                ->comment('创建时间');
            $table->dateTime('mtime')
                ->nullable(false)
                ->useCurrent()
                ->useCurrentOnUpdate()
                ->comment('创建时间');
//            $table->unsignedBigInteger('client_restrictions')
//                ->nullable(false)
//                ->default(0)
//                ->comment('使用权限储存为10进制，运算为2进制，7&(1|2|4) = 7 表明1，2，4都有权限');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yxzx_coupon_rule');
    }
}
