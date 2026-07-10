<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    protected $fillable = ['user_id', 'banned_by', 'reason', 'expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bannedBy()
    {
        return $this->belongsTo(User::class, 'banned_by');
    }
}
