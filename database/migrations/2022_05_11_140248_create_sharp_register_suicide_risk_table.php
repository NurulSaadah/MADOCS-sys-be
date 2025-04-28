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
        Schema::create('sharp_register_suicide_risk', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('added_by');
            $table->bigInteger('patient_id')->index('patient_id');
            $table->string('result')->nullable();
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
        Schema::dropIfExists('sharp_register_suicide_risk');
    }
};
