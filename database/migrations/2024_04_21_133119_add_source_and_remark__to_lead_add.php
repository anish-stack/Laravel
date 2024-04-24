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
        Schema::table('lead_adds', function (Blueprint $table) {
            //
            $table->string('la_source')->after('la_as_id');
            $table->string('la_remark')->after('la_as_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lead_adds', function (Blueprint $table) {
            //
        });
    }
};
