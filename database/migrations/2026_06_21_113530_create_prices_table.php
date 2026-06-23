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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->cascadeOnDelete();
            $table->foreignId('mode_id')->constrained('modes')->cascadeOnDelete();
            $table->tinyInteger('position');
            $table->tinyInteger('count')->default('1');
            $table->decimal('winner_amount', 10, 2);
            $table->decimal('super_agent_amount', 10, 2)->nullable();
            $table->decimal('agent_amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
