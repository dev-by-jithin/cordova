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
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $table->foreignId('mode_id')->constrained('modes')->cascadeOnDelete();
            $table->foreignId('scheme_id')->constrained('schemes')->cascadeOnDelete();
            $table->decimal('rate', 10, 2)->nullable();
            $table->decimal('admin_amount', 10, 2)->nullable();
            $table->decimal('super_agent_amount', 10, 2)->nullable();
            $table->decimal('agent_amount', 10, 2)->nullable();
            $table->unique(['ticket_id', 'mode_id', 'scheme_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
