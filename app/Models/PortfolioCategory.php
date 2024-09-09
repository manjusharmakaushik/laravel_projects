<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PortfolioCategory extends Model
{
    use softDeletes, HasFactory;
    protected $fillable = [
        'category_name',
        'category_image',
        'status'
    ];
}
