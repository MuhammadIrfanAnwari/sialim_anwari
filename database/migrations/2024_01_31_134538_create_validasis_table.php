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
        Schema::create('validasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_dokumen')
                    ->constrained('dokumens')
                    ->cascadeOnUpdate()
                    ->restrictedOnDelete();
            $table->foreignId('id_user')
                    ->constrained('users')
                    ->cascadeOnUpdate()
                    ->restrictedOnDelete();
            $table->enum('status', ['valid', 'unvalid']);
            $table->text('alasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validasis');
    }
};
