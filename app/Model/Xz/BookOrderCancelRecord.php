<?php

namespace App\Model\Xz;

use Illuminate\Database\Eloquent\Model;

class BookOrderCancelRecord extends Model
{
    protected $connection = 'mysql.production';

    protected $table = 'bookordercancelrecord';
}
