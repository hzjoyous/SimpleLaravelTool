<?php

namespace App\Model\Xz;

use Illuminate\Database\Eloquent\Model;

class OrderPriceItem extends Model
{
    protected $connection = 'mysql.production';

    protected $table = 'orderpriceitem';
}
