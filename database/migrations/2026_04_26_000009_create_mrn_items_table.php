<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mrn_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mrn_id')->constrained('material_receipt_notes')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items');
            $table->decimal('qty_received', 12, 3);
            $table->string('reel_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mrn_items');
    }
};
