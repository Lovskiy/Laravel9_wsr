<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $guarded = false;

    protected $fillable = [
        'table_id',
        'work_shift_id',
        'create_at',
        'status',
        'price',
        'number_of_person'
    ];

    public $timestamps = false;

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id', 'id');
    }

    public function statused()
    {
        return $this->belongsTo(Statused::class, 'status', 'id');
    }
}
