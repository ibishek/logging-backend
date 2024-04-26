<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadToUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'supervisor_id',
        'user_id',
    ];
}
