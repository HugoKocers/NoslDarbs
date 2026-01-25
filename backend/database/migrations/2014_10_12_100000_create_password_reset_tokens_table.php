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
        // This table is already created in the create_users_table migration
        // So we don't need to do anything here
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop this table on rollback since it's created in create_users_table
    }
};
