<?php

namespace App\Http\Resources;

use App\Models\WorkShift;
use Illuminate\Http\Resources\Json\JsonResource;

class ChiefOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'table' => $this->table->name,
            'shift_workers' => WorkShift::getUserName($this->work_shift_id),
            'create_at' => $this->create_at,
            'status' => $this->statused->name,
            'price' => $this->price
        ];
    }
}
