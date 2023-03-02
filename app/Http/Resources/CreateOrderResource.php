<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CreateOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'table' => $this->table->name,
            'shift_workers' => $this->work_shift_id,
            'create_at' => $this->create_at,
            'status' => $this->status,
            'price' => $this->price
        ];
    }
}
