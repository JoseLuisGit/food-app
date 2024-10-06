<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    use HasFactory;

    protected $primaryKey = 'extra_id';
    protected $fillable = [
        'extra_id',
        'name',
        'price',
        'image',
        'type'
    ];
}
