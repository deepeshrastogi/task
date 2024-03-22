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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->text('subject');
            $table->longText('description')->nullable();
            $table->date('start_date');
            $table->date('due_date');
            $table->enum('status', ['New', 'Incomplete', 'Completed'])->default('New');
            $table->enum('priority', ['Low', 'Medium', 'High']);
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
