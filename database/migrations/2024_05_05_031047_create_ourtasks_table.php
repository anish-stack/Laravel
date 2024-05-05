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
        Schema::create('ourtasks', function (Blueprint $table) {
            $table->bigIncrements('ot_id');
            $table->string('ot_name');
            $table->string('ot_remark');
            $table->dateTime('ot_remind_dt');
            $table->string('ot_status')->default('incomplete');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ourtasks');
    }
};
