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
        Schema::create('lead_adds', function (Blueprint $table) {
            $table->bigIncrements('la_id');
            $table->string('la_customerNname');
            $table->string('la_mobile');
            $table->string('la_address');
            $table->string('la_city');
            $table->foreign('la_an_id')->references('lpn_id')->on('lead_project_names')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('la_as_id')->references('las_id')->on('lead_available_sizes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('la_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_adds');
    }
};
