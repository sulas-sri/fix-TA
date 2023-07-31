<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionShowResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'amount' => $this->amount,
            'description' => $this->description,
    'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // Add other attributes needed for the show view
        ];
    }
}
