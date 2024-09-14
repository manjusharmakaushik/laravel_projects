<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{  
    use HasFactory;
    protected $fillable = [
        'servicetech_name',
        'sort_desc',
        'image',
        'status'
    ];
}
