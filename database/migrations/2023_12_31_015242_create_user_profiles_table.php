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
        Schema::create(table: 'user_profiles', callback: function (Blueprint $table) {
            $table->id();

            $table
                ->unsignedBigInteger(column: 'saas_client_id')
                ->foreign('saas_client_id')
                ->references('id')
                ->nullable()
                ->on('saas_clients');
            $table
                ->unsignedBigInteger(column: 'user_id')
                ->foreign('user_id')
                ->references('id')
                ->on('users');
            $table
                ->unsignedBigInteger(column: 'profile_id')
                ->foreign('profile_id')
                ->references('id')
                ->on('profiles');

            // Campos de Auditoria - "criado_em"
            $table->timestamp(column: 'created_at')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'user_profiles');
    }
};
