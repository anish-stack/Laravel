<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadPipeline extends Model
{
    use HasFactory;
    protected $primaryKey = 'lp_id';
    protected $table = 'lead_pipelines';
    protected $guarded = [];
}
