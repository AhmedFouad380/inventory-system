<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mrr_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mrr_id')->constrained('material_return_requests')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items');
            $table->decimal('qty_returned', 12, 3);
            $table->string('return_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mrr_items');
    }
};
