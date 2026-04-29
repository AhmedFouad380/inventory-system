<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_disposal_requests', function (Blueprint $table) {
            $table->id();
            $table->string('mdr_number')->unique();
            $table->foreignId('work_order_id')->constrained('work_orders');
            $table->date('mdr_date');
            $table->enum('disposal_reason', ['damaged', 'scrap', 'expired', 'excess']);
            $table->string('disposal_method')->nullable();
            $table->enum('status', ['draft', 'pending_approval', 'approved', 'executed'])->default('draft');
            $table->foreignId('prepared_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('inspection_notes')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_disposal_requests');
    }
};
