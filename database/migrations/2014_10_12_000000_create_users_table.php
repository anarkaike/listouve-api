<?php

use Illuminate\{
    Database\Migrations\Migration,
    Database\Schema\Blueprint,
    Support\Facades\Schema,
};

/**
 * Migration para gerar a entidade users
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(table: 'users', callback: function (Blueprint $table) {
            $table->id();
            $table->string(column: 'name');
            $table->string(column: 'email')->unique();
            $table->timestamp(column: 'email_verified_at')->nullable();
            $table->string(column: 'password');
            $table->rememberToken();

            $table->string(column: 'phone_personal', length: 30)->nullable();
            $table->string(column: 'phone_professional', length: 30)->nullable();
            $table->string(column: 'url_photo', length: 255)->nullable();
            $table->enum(column: 'status', allowed: ['active', 'blocked'])->default(value: 'active');
            $table->json(column: 'general_settings')->nullable();

            // Campos de Auditoria - "criado_em" e "criado_por"
            $table->timestamp(column: 'created_at')->useCurrent()->nullable()->default(value: null);
            $table->unsignedBigInteger(column: 'created_by')->nullable()->default(value: null)->useCurrent()
                ->foreign('created_by')
                ->references('id') // Nome da coluna da tabela referenciada
                ->on('users'); // Nome da tabela referenciada;
            // Campos de Auditoria - "atualizado_em" e "atualizado_por"
            $table->timestamp(column: 'updated_at')->default(value: null)->useCurrentOnUpdate()->nullable();
            $table->unsignedBigInteger(column: 'updated_by')->nullable()
                ->foreign('updated_by')
                ->references('id') // Nome da coluna da tabela referenciada
                ->on('users'); // Nome da tabela referenciada;
            $table->json(column: 'updated_values')->nullable(); // Guarda histórico de modificações. em formado json Users[]
            // Campos de Auditoria - "deletado_em" e "deletado_por"
            $table->softDeletes()->default(value: null);
            $table->unsignedBigInteger(column: 'deleted_by')->nullable()->default(value: null)
                ->foreign('updated_by')
                ->references('id') // Nome da coluna da tabela referenciada
                ->on('users'); // Nome da tabela referenciada;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(table: 'users', callback: function (Blueprint $table) {
            $table->dropForeign(['created_by', 'updated_by', 'deleted_by']);
            $table->dropIfExists();
        });
    }
};
