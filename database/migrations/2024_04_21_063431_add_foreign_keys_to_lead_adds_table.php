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

            $table->foreign('la_pn_id')
                ->references('lpn_id')->on('lead_project_names')
                ->onDelete('cascade') // On delete cascade
                ->onUpdate('cascade'); // On update cascade

            // Add foreign key constraint for la_pn_id column
            $table->foreign('la_as_id')
                ->references('las_id')->on('lead_available_sizes')
                ->onDelete('cascade') // On delete cascade
                ->onUpdate('cascade'); // On update cascade
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lead_adds', function (Blueprint $table) {
            //
            $table->dropForeign(['la_as_id']);

            // Drop foreign key constraint for la_pn_id column
            $table->dropForeign(['la_pn_id']);

            
        });
    }
};
