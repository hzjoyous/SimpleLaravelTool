<?php

namespace App\Model\Xz;

use Illuminate\Database\Eloquent\Model;

class BookOrderTenant extends Model
{
    protected $connection = 'mysql.production';

    protected $table = 'bookordertenant';
}
