<?php

namespace App\Http\Resources\Management;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReferResource extends JsonResource
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
            'slug' => $this->slug,
            'name' => $this->name,
            'employee_name' => $this->employee_name,
            'employee_number' => $this->employee_number,
            'employee_image' => $this->employee_image ? asset('storage/' . $this->employee_image) : null,
            'employee_department' => $this->employee_department,
            'ax_store_name' => $this->ax_store_name,
            'job' => $this->job,
            'whatsapp' => $this->whatsapp,
            'location' => $this->location,
            'details' => $this->details,
            'status' => (bool) $this->status,
            'is_group_manager' => (bool) $this->is_group_manager,
            'code' => $this->code,
            'account' => [
                'id' => $this->account->id ?? null,
                'name' => $this->account->user_name ?? null,
                'email' => $this->account->email ?? null,
                'mobile' => $this->account->mobile ?? null,
                'image' => $this->account->image ? asset('storage/' . $this->account->image) : null,
                'status' => $this->account->status ?? null,
            ],
            'managers' => $this->whenLoaded('managers', function() {
                return $this->managers->map(function($manager) {
                    return [
                        'id' => $manager->id,
                        'name' => $manager->name,
                        'status' => (bool) $manager->status,
                    ];
                });
            }),
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null,
        ];
    }
}
