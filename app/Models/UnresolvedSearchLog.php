<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnresolvedSearchLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'query',
        'ip_address',
        'user_agent',
    ];
}
