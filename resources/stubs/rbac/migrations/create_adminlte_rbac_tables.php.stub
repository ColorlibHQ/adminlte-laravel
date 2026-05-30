<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adminlte_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label')->nullable();
            $table->timestamps();
        });

        Schema::create('adminlte_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label')->nullable();
            $table->timestamps();
        });

        Schema::create('adminlte_role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('adminlte_roles')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unique(['role_id', 'user_id']);
        });

        Schema::create('adminlte_permission_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permission_id')->constrained('adminlte_permissions')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('adminlte_roles')->cascadeOnDelete();
            $table->unique(['permission_id', 'role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adminlte_permission_role');
        Schema::dropIfExists('adminlte_role_user');
        Schema::dropIfExists('adminlte_permissions');
        Schema::dropIfExists('adminlte_roles');
    }
};
