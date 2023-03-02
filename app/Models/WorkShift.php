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

    public function users()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }

    public static function getUserName($id)
    {
        $WorkShiftData = WorkShift::find($id);
        $id_user = $WorkShiftData->user_id;
        $data = User::where('id', $id_user)->first();

        return $data->name;
    }
}
