<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShift extends Model
{
    use HasFactory;

    protected $table = 'shift';
    protected $guarded = false;

    protected $fillable = [
        'user_id',
        'start',
        'end',
        'active'
    ];

    public $timestamps = false;
}
