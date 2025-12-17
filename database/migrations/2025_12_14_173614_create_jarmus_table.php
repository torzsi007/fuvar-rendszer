<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jarmus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fuvarozo_id')->constrained('fuvarozos')->onDelete('cascade');
            $table->string('marka');
            $table->string('tipus');
            $table->string('rendszam')->unique();
            $table->timestamps();

            $table->index('fuvarozo_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jarmus');
    }
};
