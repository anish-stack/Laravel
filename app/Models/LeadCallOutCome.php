<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadCallOutCome extends Model
{
    use HasFactory;

    protected $primaryKey = 'lco_id';
    protected $table = 'lead_call_out_comes';
    protected $fillable = [
        'lco_name', 'lco_status'
    ];

}

