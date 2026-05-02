<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create supplier_returns table
        Schema::create('supplier_returns', function (Blueprint $table) {
            $table->id();
            $table->string('return_number')->unique();
            $table->foreignId('work_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->date('return_date');
            $table->string('status')->default('draft'); // draft, approved
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Create supplier_return_items table
        Schema::create('supplier_return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_return_id')->constrained()->cascadeOnDelete();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->decimal('qty', 15, 2);
            $table->timestamps();
        });

        // 3. Update work_order_stocks table
        Schema::table('work_order_stocks', function (Blueprint $table) {
            if (!Schema::hasColumn('work_order_stocks', 'qty_returned_to_supplier')) {
                $table->decimal('qty_returned_to_supplier', 15, 2)->default(0)->after('qty_transfer_in');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_return_items');
        Schema::dropIfExists('supplier_returns');
        Schema::table('work_order_stocks', function (Blueprint $table) {
            if (Schema::hasColumn('work_order_stocks', 'qty_returned_to_supplier')) {
                $table->dropColumn('qty_returned_to_supplier');
            }
        });
    }
};
