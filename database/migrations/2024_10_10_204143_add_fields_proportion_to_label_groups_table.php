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
            $table->decimal('proportion_top', 5, 2)->default(0);
            $table->decimal('proportion_left', 5, 2)->default(0);
            $table->decimal('proportion_width', 5, 2)->default(0);
            $table->decimal('proportion_height', 5, 2)->default(0);
            $table->string('proportion_text_align')->default('left');
            $table->string('proportion_font_size')->default('14px');
            $table->string('proportion_visibility')->default('hidden');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('label_groups', function (Blueprint $table) {
            //
            $table->dropColumn('proportion_top');
            $table->dropColumn('proportion_left');
            $table->dropColumn('proportion_width');
            $table->dropColumn('proportion_height');
            $table->dropColumn('proportion_text_align');
            $table->dropColumn('proportion_font_size');
            $table->dropColumn('proportion_visibility');
        });
    }
};
