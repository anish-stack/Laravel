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
            $table->unsignedBigInteger('la_pn_id');
            $table->unsignedBigInteger('la_as_id');
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
