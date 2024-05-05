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
            $table->unsignedBigInteger('la_user_id')->nullable();
            $table->unsignedBigInteger('la_pn_id');
            $table->unsignedBigInteger('la_as_id');
            $table->string('la_status');           
            $table->timestamps();

            $table->foreign('la_pn_id')
                ->references('lpn_id')->on('lead_project_names')
                ->onDelete('cascade') // On delete cascade
                ->onUpdate('cascade'); // On update cascade

            // Add foreign key constraint for la_pn_id column
            $table->foreign('la_as_id')
                ->references('las_id')->on('lead_available_sizes')
                ->onDelete('cascade') // On delete cascade
                ->onUpdate('cascade'); // On update cascade

            $table->foreign('la_user_id') // corrected to 'la_user_id'
            ->references('id')->on('users')
            ->onDelete('cascade') // On delete cascade
            ->onUpdate('cascade'); // On update cascade
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
