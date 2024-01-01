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
        Schema::create(table: 'profiles', callback: function (Blueprint $table) {
            $table->id();
            $table->string(column: 'name', length: 255);
            $table->string(column: 'description', length: 255)->nullable();


            // Campos de Auditoria - "criado_em" e "criado_por"
            $table->timestamp(column: 'created_at')->useCurrent()->nullable();
            $table->unsignedBigInteger(column: 'created_by')->nullable()->default(value: null)->useCurrent()
                ->foreign('created_by')
                ->references('id') // Nome da coluna da tabela referenciada
                ->on('users'); // Nome da tabela referenciada
            // Campos de Auditoria - "atualizado_em" e "atualizado_por"
            $table->timestamp(column: 'updated_at')->useCurrentOnUpdate()->nullable()->default(value: null);
            $table->unsignedBigInteger(column: 'updated_by')->nullable()
                ->foreign('updated_by')
                ->references('id') // Nome da coluna da tabela referenciada
                ->on('users'); // Nome da tabela referenciada
            $table->json(column: 'updated_values')->nullable(); // Guarda histórico de modificações. em formado json Users[]
            // Campos de Auditoria - "deletado_em" e "deletado_por"
            $table->softDeletes();
            $table->unsignedBigInteger(column: 'deleted_by')->nullable()->default(value: null)
                ->foreign('updated_by')
                ->references('id') // Nome da coluna da tabela referenciada
                ->on('users'); // Nome da tabela referenciada

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'profile');
    }
};
