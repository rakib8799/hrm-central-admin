<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('subscription_plans')->truncate();
        DB::table('subscription_plans')->insert([
            [
                'id' => 1,
                'name' => 'Small',
                'slug' => 'small-monthly',
                'price' => 750,
                'plan_type' => 'monthly',
                'duration' => 1,
                'duration_unit' => 'months',
                'trial_duration' => 1,
                'trial_duration_unit' => 'months',
                'max_active_users' => 10,
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'name' => 'Medium',
                'slug' => 'medium-monthly',
                'price' => 1500,
                'plan_type' => 'monthly',
                'duration' => 1,
                'duration_unit' => 'months',
                'trial_duration' => 1,
                'trial_duration_unit' => 'months',
                'max_active_users' => 25,
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'name' => 'Large',
                'slug' => 'large-monthly',
                'price' => 2250,
                'plan_type' => 'monthly',
                'duration' => 1,
                'duration_unit' => 'months',
                'trial_duration' => 1,
                'trial_duration_unit' => 'months',
                'max_active_users' => 50,
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'name' => 'Small',
                'slug' => 'small-yearly',
                'price' => 8000,
                'plan_type' => 'yearly',
                'duration' => 12,
                'duration_unit' => 'months',
                'trial_duration' => 6,
                'trial_duration_unit' => 'months',
                'max_active_users' => 10,
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id' => 5,
                'name' => 'Medium',
                'slug' => 'medium-yearly',
                'price' => 16000,
                'plan_type' => 'yearly',
                'duration' => 12,
                'duration_unit' => 'months',
                'trial_duration' => 6,
                'trial_duration_unit' => 'months',
                'max_active_users' => 25,
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id' => 6,
                'name' => 'Large',
                'slug' => 'large-yearly',
                'price' => 24000,
                'plan_type' => 'yearly',
                'duration' => 12,
                'duration_unit' => 'months',
                'trial_duration' => 6,
                'trial_duration_unit' => 'months',
                'max_active_users' => 50,
                'is_active' => true,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
