<?php

namespace App\Models\Company;

use App\Models\Subscription\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'domain',
        'workspace',
        'allowed_domains',
        'created_by',
        'updated_by',
        'is_active',
    ];

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
}
