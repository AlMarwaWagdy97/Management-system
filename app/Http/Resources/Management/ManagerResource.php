<?php

namespace App\Http\Resources\Management;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManagerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => (bool) $this->status,
            'account' => $this->whenLoaded('account', function () {
                return [
                    'id' => $this->account->id,
                    'email' => $this->account->email,
                    'mobile' => $this->account->mobile,
                    'user_name' => $this->account->user_name,
                    'image' => $this->account->image ? asset('storage/' . $this->account->image) : null,
                ];
            }),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
