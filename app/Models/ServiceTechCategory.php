<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceTechCategory extends Model
{
    use HasFactory;
    protected $table = 'service_tech_categories';
    protected $primaryKey='service_id';
    protected $fillable = [
        'service_id',
        'servicetech_name',
        'image',
        'status'
    ];
}
