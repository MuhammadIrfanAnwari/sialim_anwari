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
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_sub_kriteria')
                    ->constrained('sub_kriterias')
                    ->cascadeOnUpdate()
                    ->restrictedOnDelete();
            $table->foreignId('id_bagian')
                    ->constrained('bagians')
                    ->cascadeOnUpdate()
                    ->restrictedOnDelete();
            $table->foreignId('id_user')
                    ->constrained('users')
                    ->cascadeOnUpdate()
                    ->restrictedOnDelete();
            $table->string('dokumen');
            $table->string('judul');
            $table->enum('status', ['menunggu', 'valid', 'unvalid']);
            $table->enum('privasi', ['public', 'private']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
