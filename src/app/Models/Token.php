<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

class Token extends Model
{
    use HasFactory;

    protected $table = 'personal_access_tokens';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'token',
        'expires_at',
        'created_at',
        'last_used_at'
    ];
}
