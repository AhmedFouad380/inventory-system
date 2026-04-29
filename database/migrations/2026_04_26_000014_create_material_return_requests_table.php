<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_return_requests', function (Blueprint $table) {
            $table->id();
            $table->string('mrr_number')->unique();
            $table->foreignId('work_order_id')->constrained('work_orders');
            $table->date('mrr_date');
            $table->string('return_to');
            $table->string('transport_details')->nullable();
            $table->string('receiver_signature')->nullable();
            $table->enum('status', ['draft', 'approved', 'confirmed'])->default('draft');
            $table->foreignId('prepared_by')->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_return_requests');
    }
};
