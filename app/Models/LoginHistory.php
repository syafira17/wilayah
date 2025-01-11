<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    protected $table = 'login_history';
    
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'login_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 