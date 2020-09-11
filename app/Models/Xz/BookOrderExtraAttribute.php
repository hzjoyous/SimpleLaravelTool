<?php

namespace App\Models\Xz;

use Illuminate\Database\Eloquent\Model;

class BookOrderExtraAttribute extends Model
{
    protected $connection = 'mysql.production';

    protected $table = 'bookorderextraattribute';
}
