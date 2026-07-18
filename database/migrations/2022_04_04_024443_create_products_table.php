<?php

use App\Models\LabelGroup;
use App\Models\HazardClass;
use App\Models\UnitMeasurement;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('comercial_name', 255);
            $table->string('internal_name', 255)->nullable();
            $table->string('chemycal_type', 255)->nullable();
            $table->string('liquid_substance', 255)->nullable();
            $table->string('technical_features', 255)->nullable();
            $table->string('un_number', 10)->nullable();
            $table->text('production_instruction')->nullable();
            $table->string('signal_word', 10)->nullable();
            $table->string('cure');
            $table->string('viscosity');
            $table->string('thickness');
            $table->float('weight', 8, 3);
            $table->string('image')->nullable();

            $table->foreignIdFor(HazardClass::class)->constrained();
            $table->foreignIdFor(LabelGroup::class)->constrained();
            $table->foreignId('unit_measurement_id')
                ->references('id')
                ->on('units_measurement')
                ->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
