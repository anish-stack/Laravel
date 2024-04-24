<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadAvailableSize extends Model
{
    use HasFactory;
    protected $primaryKey = 'las_id';
    protected $table = 'lead_available_sizes';
    protected $guarded = [];
}
