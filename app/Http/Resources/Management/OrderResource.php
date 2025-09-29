<?php

namespace App\Http\Resources\Management;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            // "payment_method_key" => $this->payment_method_key,
            // "source" =>  $this->source,
            "store_id" => $this->refer,
            // "donor_name" => $this->full_name,
            // "donor_mobile" =>  $this->donor_mobile,
            // "donor_email" =>  $this->donor_email,
            "create_date" => $this->created_at,
            'identifier' => $this->identifier,
            'total' => (float) $this->total,
            'quantity' => (int) $this->quantity,
            'payment_method' => [
                'key' => $this->payment_method_key,
                'name' => $this->paymentMethodTranslationEn->name ?? null,
            ],
            'source' => $this->source,
            'store' => [
                'id' => $this->refer,
                'name' => $this->store_name ?? null,
            ],
            'donor' => [
                'name' => $this->full_name,
                'mobile' => $this->donor_mobile,
                'email' => $this->donor_email,
            ],
            'status' => $this->status,
            'status_label' => $this->getStatusLabel($this->status),
            'created_at' => $this->created_at ? $this->created_at->toIso8601String() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toIso8601String() : null,
            'items' => $this->whenLoaded('items', function () {
                return $this->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'quantity' => (int) $item->quantity,
                        'price' => (float) $item->price,
                        'total' => (float) $item->total,
                    ];
                });
            }, []),
        ];
    }

    /**
     * Get the human-readable status label
     *
     * @param string $status
     * @return string
     */
    protected function getStatusLabel($status)
    {
        $statuses = [
            'pending' => 'قيد الانتظار',
            'processing' => 'قيد المعالجة',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
            'refunded' => 'مسترد',
        ];

        return $statuses[$status] ?? $status;
    }
}