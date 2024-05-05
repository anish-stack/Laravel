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
             $table->date('la_last_update')->nullable()->after('la_status');
             $table->date('la_meeting_date')->nullable()->after('la_status');
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
