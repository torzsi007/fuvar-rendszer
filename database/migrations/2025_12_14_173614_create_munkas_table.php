<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('munkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fuvarozo_id')->nullable()->constrained('fuvarozos')->nullOnDelete();
            $table->string('kiindulo_cim');
            $table->string('erkezesi_cim');
            $table->string('cimzett_nev');
            $table->string('cimzett_telefon');
            $table->enum('statusz', [
                'kiosztva',
                'folyamatban',
                'elvegezve',
                'sikertelen'
            ])->default('kiosztva');
            $table->timestamps();

            $table->index('fuvarozo_id');
            $table->index('statusz');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('munkas');
    }
};
