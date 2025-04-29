<?php

namespace App\Models\EmailService;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'api_key',
        'username',
        'password',
        'base_url',
        'from_email',
    ];
}
