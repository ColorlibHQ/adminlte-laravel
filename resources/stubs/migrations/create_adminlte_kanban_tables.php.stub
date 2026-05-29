<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adminlte_kanban_boards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('adminlte_kanban_lanes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_id')->constrained('adminlte_kanban_boards')->cascadeOnDelete();
            $table->string('name');
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('adminlte_kanban_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lane_id')->constrained('adminlte_kanban_lanes')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('color')->default('primary');
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('adminlte_kanban_card_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id')->constrained('adminlte_kanban_cards')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unique(['card_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adminlte_kanban_card_user');
        Schema::dropIfExists('adminlte_kanban_cards');
        Schema::dropIfExists('adminlte_kanban_lanes');
        Schema::dropIfExists('adminlte_kanban_boards');
    }
};
