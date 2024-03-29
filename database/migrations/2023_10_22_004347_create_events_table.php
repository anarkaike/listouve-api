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
        Schema::create(table: 'events', callback: function (Blueprint $table) {
            $table->id();

            $table->string(column: 'name', length: 255);
            $table->timestamp(column: 'starts_at')->nullable();
            $table->timestamp(column: 'ends_at')->nullable();
            $table->integer(column: 'duration_in_hours')->nullable();
            $table->text(column: 'description')->nullable();
            $table->string(column: 'url_banner', length: 255)->nullable();
            $table->string(column: 'address', length: 255)->nullable();
            $table->string(column: 'city', length: 255)->nullable();
            $table->string(column: 'state', length: 255)->nullable();
            $table->string(column: 'contact_info', length: 255)->nullable();
            $table->string(column: 'attractions_info', length: 255)->nullable();
            $table->string(column: 'payment_info', length: 255)->nullable();
            $table->string(column: 'restrictions_info', length: 255)->nullable();
            $table->string(column: 'ticket_info', length: 255)->nullable();
            $table->json(column: 'social_networks')->nullable();

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
            $table->json(column: 'updated_values')->nullable(); // Guarda histórico de modificações. em formado json Users[]
            // Campos de Auditoria - "deletado_em" e "deletado_por"
            $table->softDeletes()->default(value: null);
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
        Schema::table(table: 'events', callback: function (Blueprint $table) {
            $table->dropForeign(['saas_client_id', 'created_by', 'updated_by', 'deleted_by']);
            $table->dropIfExists();
        });
    }
};
