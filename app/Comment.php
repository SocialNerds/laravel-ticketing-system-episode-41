<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'user_id', 'ticket_id', 'comment'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
