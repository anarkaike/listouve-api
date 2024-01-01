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
        Schema::create(table: 'profile_permissions', callback: function (Blueprint $table) {
            $table->id();

            $table
                ->unsignedBigInteger(column: 'permission_id')
                ->foreign('permission_id')
                ->references('id')
                ->on('permissions');
            $table
                ->unsignedBigInteger(column: 'profile_id')
                ->foreign('profile_id')
                ->references('id')
                ->on('profiles');

            // Campos de Auditoria - "criado_em" e "criado_por"
            $table->timestamp(column: 'created_at')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'profile_permissions');
    }
};
