<?php

use Illuminate\{
    Database\Migrations\Migration,
    Database\Schema\Blueprint,
    Support\Facades\Schema,
};

/**
 * Migration para gerar a entidade saas_clients
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(table: 'saas_clients', callback: function (Blueprint $table) {
            $table->id();

            $table->string(column: 'name', length: 255);
            $table->string(column: 'email_personal', length: 255);
            $table->string(column: 'email_pofessional', length: 255);
            $table->string(column: 'phone_personal', length: 20);
            $table->string(column: 'phone_pofessional', length: 20);
            $table->longText(column: 'observation',);
            $table->enum(column: 'status', allowed: ['active', 'active_testing', 'active_pending_payment', 'blocked', 'blocked_pending_payment', 'archived',])->default(value: 'active');
            $table->json(column: 'general_settings')->nullable();

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
        Schema::table(table: 'saas_clients', callback: function (Blueprint $table) {
            $table->dropForeign(['saas_client_id', 'created_by', 'updated_by', 'deleted_by']);
            $table->dropIfExists();
        });
    }
};
