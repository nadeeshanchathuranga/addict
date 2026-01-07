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
        Schema::table('sale_items', function (Blueprint $table) {
            // Add new discount-related fields if they do not already exist
            if (!Schema::hasColumn('sale_items', 'apply_discount')) {
                $table->boolean('apply_discount')->default(false)->after('discount')->comment('Whether discount is applied to this item');
            }
            if (!Schema::hasColumn('sale_items', 'discounted_price')) {
                $table->decimal('discounted_price', 10, 2)->nullable()->after('apply_discount')->comment('Final price after applying discount');
            }
            if (!Schema::hasColumn('sale_items', 'include_custom')) {
                $table->boolean('include_custom')->default(false)->after('discounted_price')->comment('Whether item is included in custom discount');
            }
            if (!Schema::hasColumn('sale_items', 'selling_price')) {
                $table->decimal('selling_price', 10, 2)->nullable()->after('include_custom')->comment('Original selling price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_items', function (Blueprint $table) {
            $columnsToDrop = [];
            foreach ([
                'apply_discount',
                'discounted_price',
                'include_custom',
                'selling_price',
            ] as $column) {
                if (Schema::hasColumn('sale_items', $column)) {
                    $columnsToDrop[] = $column;
                }
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
