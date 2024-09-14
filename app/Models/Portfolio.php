<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_name',
        'sort_disc',
        'project_complete_year',
        'technology',
        'project_image',
        'status'
    ];
}
