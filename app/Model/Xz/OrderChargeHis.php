<?php

namespace App\Model\Xz;

use Illuminate\Database\Eloquent\Model;

class OrderChargeHis extends Model
{
    protected $connection = 'mysql.production';

    protected $table = 'orderchargehis';
}
