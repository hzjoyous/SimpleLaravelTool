<?php

namespace App\Model\Xz;

use Illuminate\Database\Eloquent\Model;

class BookOrder extends Model
{
    protected $connection = 'mysql.test';

    protected $table = 'bookorder';
}
