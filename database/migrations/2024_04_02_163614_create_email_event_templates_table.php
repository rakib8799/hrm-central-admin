<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_event_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_provider_id')->constrained()->cascadeOnDelete();
            $table->foreignId('email_event_id')->constrained()->cascadeOnDelete();
            $table->string('template_id');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_event_templates');
    }
};
