<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LeadUpdateRecord extends Model
{
    use HasFactory;
    protected $primaryKey = 'lur_id';
    protected $table = 'lead_update_records';
    protected $guarded = [];

     public function user(){
        return $this->belongsTo(User::class,'lur_user_id');
    }
}
