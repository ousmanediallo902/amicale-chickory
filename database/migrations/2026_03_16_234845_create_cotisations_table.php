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
    Schema::create('cotisations', function (Blueprint $table) {
        $table->id();

        $table->foreignId('etudiant_id')
              ->constrained()
              ->onDelete('cascade');

        $table->string('mois');
        $table->integer('annee');
        $table->double('montant');
        $table->enum('statut', ['paye', 'non_paye'])->default('non_paye');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotisations');
    }
};
