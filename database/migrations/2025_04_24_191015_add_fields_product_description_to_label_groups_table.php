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
            $table->decimal('product_description_top', 5, 2)->default(0);
            $table->decimal('product_description_left', 5, 2)->default(0);
            $table->decimal('product_description_width', 5, 2)->default(0);
            $table->decimal('product_description_height', 5, 2)->default(0);
            $table->string('product_description_text_align')->default('left');
            $table->string('product_description_font_size')->default('14px');
            $table->string('product_description_visibility')->default('hidden');        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('label_groups', function (Blueprint $table) {
            $table->dropColumn('product_description_top');
            $table->dropColumn('product_description_left');
            $table->dropColumn('product_description_width');
            $table->dropColumn('product_description_height');
            $table->dropColumn('product_description_text_align');
            $table->dropColumn('product_description_font_size');
            $table->dropColumn('product_description_visibility');        
        });
    }
};
