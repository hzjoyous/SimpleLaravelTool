<?php

namespace App\Model\Xz;

use Illuminate\Database\Eloquent\Model;

class OrderCharge extends Model
{
    protected $connection = 'mysql.production';

    protected $table = 'ordercharge';
}
