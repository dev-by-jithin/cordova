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
        Schema::create('numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained('bills')->cascadeOnDelete();
            $table->foreignId('super_agent_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('agent_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('group_id')->constrained('groups');
            $table->foreignId('ticket_id')->constrained('tickets');
            $table->foreignId('mode_id')->constrained('modes');
            $table->string('number', 3);
            $table->smallInteger('count');
            $table->decimal('agent_rate', 10, 2);
            $table->decimal('rate', 10, 2);
            $table->decimal('collection', 10, 2);
            $table->decimal('commission', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('numbers');
    }
};
