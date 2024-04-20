<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadType extends Model
{
    use HasFactory;
    protected $primaryKey = 'lt_id';
    protected $table = 'lead_types';
    protected $guarded = [];
}
