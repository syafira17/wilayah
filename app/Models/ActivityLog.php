<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Wilayah;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'wilayah_id',
        'activity_type',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function getFormattedUserAgentAttribute()
    {
        return str_replace(['Mozilla/5.0', '(Windows NT', ')', ';'], '', $this->user_agent);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('activity_type', $type);
    }

    public function scopeOnDate($query, $date)
    {
        return $query->whereDate('created_at', $date);
    }
} 