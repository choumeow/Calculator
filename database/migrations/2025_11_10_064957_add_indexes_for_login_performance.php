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
        Schema::table('calculations', function (Blueprint $table) {
            // Composite index for faster user_id + created_at queries (used in orderBy)
            // This significantly speeds up queries that filter by user_id and sort by created_at
            $table->index(['user_id', 'created_at'], 'calculations_user_id_created_at_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calculations', function (Blueprint $table) {
            $table->dropIndex('calculations_user_id_created_at_index');
        });
    }
};
