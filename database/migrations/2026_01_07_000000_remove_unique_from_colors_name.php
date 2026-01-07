<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Try to drop the unique index created by ->unique() on the `name` column.
        // For MySQL the index name is typically `colors_name_unique`.
        try {
            DB::statement('ALTER TABLE `colors` DROP INDEX `colors_name_unique`');
        } catch (\Throwable $e) {
            // If the index does not exist, ignore the error so migration is idempotent.
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('colors', function (Blueprint $table) {
            $table->unique('name');
        });
    }
};
