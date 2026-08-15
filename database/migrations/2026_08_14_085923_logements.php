<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('batiment_id')->constrained()->onDelete('cascade');
            $table->string('numero')->nullable(); // Ex: Appt A1, Porte 3
            $table->enum('categorie', ['appartement', 'maison', 'studio', 'boutique', 'bureau']);
            $table->text('description')->nullable();
            $table->decimal('loyer_mensuel', 10, 2);
            $table->boolean('statut')->default(1); // 1 = Libre, 0 = Occupé
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logements');
    }
};