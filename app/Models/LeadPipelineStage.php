<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadPipelineStage extends Model
{
    use HasFactory;
    protected $primaryKey = 'lps_id';
    protected $table = 'lead_pipeline_stages';
    protected $guarded = [];
}
