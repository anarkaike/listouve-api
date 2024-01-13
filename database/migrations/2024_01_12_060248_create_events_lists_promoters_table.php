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
        Schema::create(table: 'events_lists_promoters', callback: function (Blueprint $table) {
            $table->id();

            $table
                ->unsignedBigInteger(column: 'user_id')
                ->foreign('user_id')
                ->references('id')
                ->on('users');
            $table
                ->unsignedBigInteger(column: 'event_list_id')
                ->foreign('event_list_id')
                ->references('id')
                ->on('events_lists');

            // Campos de Auditoria - "criado_em" e "criado_por"
            $table->timestamp(column: 'created_at')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'events_lists_promoters');
    }
};
