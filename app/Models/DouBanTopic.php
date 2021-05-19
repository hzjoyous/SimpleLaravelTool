<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DouBanTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'topic_id',
        'group_id',
        'topic_title',
        'topic_content',
    ];

    protected $guarded = [];

    public static function getByLaterThanCreateTime($createTime): \Illuminate\Database\Eloquent\Collection|array
    {
        return self::query()->where('created_at','>',$createTime)->get();
    }

}
