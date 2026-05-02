<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasColumn('material_receipt_notes', 'reservation_number')) {
            Schema::table('material_receipt_notes', function (Blueprint $table) {
                $table->string('reservation_number')->nullable()->after('mrn_number');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('material_receipt_notes', 'reservation_number')) {
            Schema::table('material_receipt_notes', function (Blueprint $table) {
                $table->dropColumn('reservation_number');
            });
        }
    }
};
