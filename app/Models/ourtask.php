<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ourtask extends Model
{
    use HasFactory;
    protected $primaryKey = 'ot_id';
    protected $table = 'ourtasks';
    protected $guarded = [];
}
