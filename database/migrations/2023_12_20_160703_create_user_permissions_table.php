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
        Schema::create(table: 'user_permissions', callback: function (Blueprint $table) {
            $table->id();

            $table
                ->unsignedBigInteger(column: 'saas_client_id')
                ->foreign('saas_client_id')
                ->references('id')
                ->on('saas_clients');
            $table
                ->unsignedBigInteger(column: 'user_id')
                ->foreign('user_id')
                ->references('id')
                ->on('users');
            $table
                ->unsignedBigInteger(column: 'permission_id')
                ->foreign('permission_id')
                ->references('id')
                ->on('permissions');


            // Campos de Auditoria - "criado_em" e "criado_por"
            $table->timestamp(column: 'created_at')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'user_permissions');
    }
};
