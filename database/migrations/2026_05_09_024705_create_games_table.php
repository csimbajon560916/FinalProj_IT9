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
        Schema::create('games', function (Blueprint $table) {
             $table->id();
             $table->foreignId('tournament_id')->constrained()->onDelete('cascade');
             $table->foreignId('venue_id')->nullable()->constrained()->onDelete('set null');
            
             // References to the teams table
             $table->foreignId('team1_id')->nullable()->constrained('teams')->onDelete('set null');
             $table->foreignId('team2_id')->nullable()->constrained('teams')->onDelete('set null');
             $table->foreignId('next_game_id')->nullable()->constrained('games')->onDelete('set null');
            
             $table->integer('team1_score')->default(0);
             $table->integer('team2_score')->default(0);
             $table->dateTime('match_datetime')->nullable();
             $table->string('round_name')->nullable(); // e.g., "Quarter Finals"
             $table->integer('round_number')->default(1);
             $table->string('status')->default('scheduled'); // scheduled, live, completed
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
