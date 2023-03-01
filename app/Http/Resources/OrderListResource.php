<?php

namespace App\Http\Resources;

use App\Models\Menu;
use App\Models\Orders;
use App\Models\WorkShift;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{
    public function toArray($request)
    {
        $orders = Orders::select('id', 'table_id', 'work_shift_id', 'create_at', 'status', 'price')->get();

        return [
            'id' => $this->id,
            'start' => $this->start,
            'end' => $this->end,
            'active' => $this->active,
            'orders' => [
                'id' => $orders->id,
                'table' => $orders->tables->name,
                'shift_workers' => $orders->work_shift_id,
                'create_at' => $orders->create_at,
                'status' => $orders->status,
                'price' => $orders->price
            ]
         ];
    }
}
