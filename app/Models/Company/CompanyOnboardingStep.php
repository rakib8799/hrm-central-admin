<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyOnboardingStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'company_created',
        'database_created',
        'database_migrated',
        'initial_data_loaded',
        'user_created',
    ];

}
