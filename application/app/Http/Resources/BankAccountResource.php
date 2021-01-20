<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountResource extends JsonResource
{

    public function toArray($request)
    {
        $response = [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'bank_balance' => $this->bank_balance,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if (isset($request->banknotes) && !empty($request->banknotes)) {
            $response['banknotes'] = $request->banknotes;
        }

        return $response;
    }

}
