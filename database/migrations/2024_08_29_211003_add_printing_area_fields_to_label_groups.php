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
        Schema::table('label_groups', function (Blueprint $table) {
            //
            $table->decimal('printing_area_width', 5, 2)->default(21);
            $table->decimal('printing_area_height', 5, 2)->default(29);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('label_groups', function (Blueprint $table) {
            //
            $table->dropColumn('printing_area_width');
            $table->dropColumn('printing_area_height');
        });
    }
};
