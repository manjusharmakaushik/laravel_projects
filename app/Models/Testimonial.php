<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    protected $fillable = [
    'testimonial_name', 
    'sort_desc', 
    'testimonial_image', 
    'status'
];
}