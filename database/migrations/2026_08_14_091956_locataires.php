<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locataires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('logement_id')->nullable()->constrained('logements')->onDelete('set null');

            // Informations personnelles
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('email')->nullable();
            
            // Téléphones
            $table->string('phone');
            $table->string('phone_urgence')->nullable();
            
            // Financier
            $table->decimal('loyer', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locataires');
    }
};