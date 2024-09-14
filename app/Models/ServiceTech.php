<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTech extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id',
        'name',
        'image',
        'status'
    ];
}
