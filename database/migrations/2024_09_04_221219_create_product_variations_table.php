<?php

use App\Models\LabelGroup;
use App\Models\Package;
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
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            $table->foreignIdFor(Package::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(LabelGroup::class)->constrained()->onDelete('cascade');

            $table->decimal('weight', 8, 3);

            $table->foreignId('unit_measurement_id')
                ->references('id')
                ->on('units_measurement')
                ->constrained();

            $table->string('gtin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};
