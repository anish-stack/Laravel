<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadProjectName extends Model
{
    use HasFactory;
    protected $primaryKey = 'lpn_id';
    protected $table = 'lead_project_names';
    protected $guarded = [];
}
