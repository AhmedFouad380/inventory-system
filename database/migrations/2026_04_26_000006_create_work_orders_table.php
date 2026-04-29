<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('wo_number')->unique();
            $table->foreignId('project_id')->constrained('projects');
            $table->foreignId('site_id')->nullable()->constrained('sites')->nullOnDelete();
            $table->foreignId('contractor_id')->nullable()->constrained('contractors')->nullOnDelete();
            $table->string('contract_ref')->nullable();
            $table->enum('status', ['open', 'closed', 'suspended'])->default('open');
            $table->date('opened_at');
            $table->date('closed_at')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
