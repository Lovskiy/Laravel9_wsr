<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';

    protected $guarded = false;

    protected $fillable = [
        'count',
        'position',
        'price'
    ];

    public $timestamps = false;
}
