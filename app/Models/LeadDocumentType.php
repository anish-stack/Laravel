<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadDocumentType extends Model
{
    use HasFactory;
    protected $primaryKey = 'ldt_id';
    protected $table = 'lead_document_types';
    protected $guarded = [];
}
