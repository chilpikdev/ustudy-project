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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('user_id');
            $table->foreignId('user_id')->constrained('users', 'id')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->string('description');
            $table->bigInteger('view')->default(0);
            $table->bigInteger('shared')->default(0);
            $table->boolean('recommended')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('user_id')->on('users')->references('id')->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
