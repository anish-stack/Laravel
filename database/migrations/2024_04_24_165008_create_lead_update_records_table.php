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
        Schema::create('lead_update_records', function (Blueprint $table) {
            $table->bigIncrements('lur_id');
            $table->unsignedBigInteger('lur_user_id');
            $table->unsignedBigInteger('lur_leadadd_Id');
            $table->string('lur_remark');
            $table->string('lur_interest');
            $table->date('lur_meeting_date');
            $table->date('lur_update_date');
            $table->timestamps();

            $table->foreign('lur_leadadd_Id')
                ->references('la_id')->on('lead_adds')
                ->onDelete('cascade') // On delete cascade
                ->onUpdate('cascade'); // On update cascade
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_update_records');
    }
};
