<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statused extends Model
{
    use HasFactory;

    protected $table = 'statused';

    public $timestamps = false;

    protected $guarded = false;

    protected $fillable = [
        'name'
    ];

    public function orders()
    {
        return $this->hasMany(Orders::class, 'status', 'id');
    }
}
