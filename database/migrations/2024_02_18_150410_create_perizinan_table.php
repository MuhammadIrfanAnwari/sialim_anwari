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
        Schema::create('perizinan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictedOnDelete();
            $table->foreignId('id_dokumen')
                ->constrained('dokumens')
                ->cascadeOnupdate()
                ->restrictedOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perizinan');
    }
};
