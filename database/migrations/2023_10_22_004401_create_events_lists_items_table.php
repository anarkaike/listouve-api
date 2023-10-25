<?php

use Illuminate\{
    Database\Migrations\Migration,
    Database\Schema\Blueprint,
    Support\Facades\Schema,
};

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(table: 'events_lists_items', callback: function (Blueprint $table) {
            $table->id();

            $table->string(column: 'name', length: 255);
            $table->string(column: 'email', length: 255);
            $table->string(column: 'phone', length: 20);
            $table->integer(column: 'event_id');
            $table->integer(column: 'event_list_id');
            $table->enum(column: 'payment_status', allowed: ['pending', 'paid'])->default('pending');

            $table
                ->unsignedBigInteger(column: 'saas_client_id')->nullable()->default(value: null)
                ->foreign('saas_client_id')
                ->references('id') // Nome da coluna da tabela referenciada
                ->on('saas_clients'); // Nome da tabela referenciada


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
        Schema::table(table: 'events_lists_items', callback: function (Blueprint $table) {
            $table->dropForeign(['saas_client_id', 'created_by', 'updated_by', 'deleted_by']);
            $table->dropIfExists();
        });
    }
};
