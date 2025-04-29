<?php

namespace App\Models\EmailService;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailEventTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_event_id',
        'email_provider_id',
        'template_id',
        'is_active',
    ];
}
