<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DouBanTopic extends Model
{
    use HasFactory;

    protected $user_id;
    protected $group_id;
    protected $topic_id;
    protected $topic_title;
    protected $topic_content;

    protected $fillable = [
        'user_id',
        'topic_id',
        'group_id',
        'topic_title',
        'topic_content',
    ];

    protected $guarded = [];
}
