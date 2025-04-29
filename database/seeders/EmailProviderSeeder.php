<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('email_providers')->truncate();
        DB::table('email_providers')->insert([
            'name' => 'Sendgrid',
            'slug' => 'sendgrid',
            'api_key' => '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',
            'from_email' => 'mkrakib328@gmail.com',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
