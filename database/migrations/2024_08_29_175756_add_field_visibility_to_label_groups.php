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
            $table->string('product_info_visibility')->default('visible');
            $table->string('product_batch_visibility')->default('visible');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('label_groups', function (Blueprint $table) {
            //
            $table->dropColumn('product_info_visibility');
            $table->dropColumn('product_batch_visibility');
        });
    }
};
