<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dog extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name', 'desc'
    ];

    /**
     * @var string
     */
    protected string $name;
    /**
     * @var string
     */
    protected string $desc;

}
