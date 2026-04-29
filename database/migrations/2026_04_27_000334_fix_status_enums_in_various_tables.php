<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Gate Passes
        DB::statement("ALTER TABLE gate_passes MODIFY COLUMN status ENUM('draft', 'approved', 'issued', 'confirmed') DEFAULT 'draft'");
        
        // Material Return Requests
        DB::statement("ALTER TABLE material_return_requests MODIFY COLUMN status ENUM('draft', 'approved', 'confirmed') DEFAULT 'draft'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE gate_passes MODIFY COLUMN status ENUM('draft', 'issued', 'confirmed') DEFAULT 'draft'");
        DB::statement("ALTER TABLE material_return_requests MODIFY COLUMN status ENUM('draft', 'confirmed') DEFAULT 'draft'");
    }
};
