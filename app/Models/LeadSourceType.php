<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadSourceType extends Model
{
    use HasFactory;
  
    protected $primaryKey = 'lst_id';
    protected $table = 'lead_source_types';
    protected $guarded = [];

    
}
