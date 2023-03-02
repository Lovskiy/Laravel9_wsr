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
        $getShift = WorkShift::select('id', 'start', 'end', 'active')->first();
        $priceAll = Menu::select('price')->sum('price');

        return [
            'id' => $getShift->id,
            'start' => $getShift->start,
            'end' => $getShift->end,
            'active' => $getShift->active,
            'orders' => [
                'id' => $this->id,
                'table' => $this->table->name,
                'shift_workers' => WorkShift::getUserName($this->work_shift_id),
                'create_at' => $this->create_at,
                'status' => $this->statused->name,
                'price' => $this->price
            ],
            'amount_for_all' => $priceAll,
        ];
    }
}
