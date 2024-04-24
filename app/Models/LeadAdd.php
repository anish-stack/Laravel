<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadAdd extends Model
{
    use HasFactory;
    protected $primaryKey = 'la_id';
    protected $table = 'lead_adds';
    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(LeadProjectName::class, 'lpn_id');
    }

    public function availableSize()
    {
        return $this->belongsTo(LeadAvailableSize::class, 'las_id');
    }
}
