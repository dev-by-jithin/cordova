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
            $table->decimal('collection', 10, 2);
            $table->decimal('a_rate', 10, 2);
            $table->decimal('a_commission', 10, 2);
            $table->decimal('sa_rate', 10, 2);
            $table->decimal('sa_commission', 10, 2);
            $table->tinyInteger('prize_position')->nullable();
            $table->decimal('a_prize_commission', 10, 2)->nullable();
            $table->decimal('winner_prize', 10, 2)->nullable();
            $table->date('ticket_date');
            $table->timestamps();

            $table->index(['ticket_id', 'number', 'ticket_date']);
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
