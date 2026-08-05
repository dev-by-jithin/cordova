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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets');
            $table->date('result_date');
            $table->string('a', 1);
            $table->string('b', 1);
            $table->string('c', 1);
            $table->string('ab', 2);
            $table->string('bc', 2);
            $table->string('ac', 2);
            $table->string('super_position_1', 3);
            $table->string('super_position_2', 3);
            $table->string('super_position_3', 3);
            $table->string('super_position_4', 3);
            $table->string('super_position_5', 3);
            $table->json('super_encouragement_prize');
            $table->string('box_position_1', 3);
            $table->string('box_position_2', 3);
            $table->string('box_position_3', 3)->nullable();
            $table->string('box_position_4', 3)->nullable();
            $table->string('box_position_5', 3)->nullable();
            $table->string('box_position_6', 3)->nullable();
            $table->unique(['ticket_id', 'result_date']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
