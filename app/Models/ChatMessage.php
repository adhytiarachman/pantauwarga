<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['chat_topic_id', 'role', 'message'];

    public function topic()
    {
        return $this->belongsTo(ChatTopic::class);
    }
}
