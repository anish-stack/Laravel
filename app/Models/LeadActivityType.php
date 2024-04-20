<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadActivityType extends Model
{
    use HasFactory;

    protected $primaryKey = 'lat_id';
    protected $table = 'lead_activity_types';
    protected $guarded = [];
}
