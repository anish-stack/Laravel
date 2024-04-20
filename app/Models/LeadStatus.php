<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadStatus extends Model
{
    use HasFactory;
    protected $primaryKey = 'ls_id';
    protected $table = 'lead_statuses';
    protected $guarded = [];
}
