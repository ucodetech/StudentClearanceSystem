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
        Schema::create('desks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('users');
            $table->foreignId('request_id')->constrained('clearance_requests');
            $table->enum('flow', ['admin', 'department', 'court', 'student_affairs', 'final_admin']);
            $table->integer('sort');
            $table->boolean('HasWork')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desks');
    }
};
