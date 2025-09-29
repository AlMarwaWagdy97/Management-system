<?php

namespace App\Http\Resources\Management;

use Illuminate\Http\Resources\Json\JsonResource;

class CharityProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $locale = app()->getLocale();
        $translation = $this->trans->firstWhere('locale', $locale) ?? $this->trans->first();
        
        $category = $this->whenLoaded('category', function() use ($locale) {
            if ($this->category) {
                $catTrans = $this->category->trans->firstWhere('locale', $locale) ?? $this->category->trans->first();
                return [
                    'id' => $this->category->id,
                    'name' => $catTrans->name ?? null,
                ];
            }
            return null;
        });

        $tags = $this->whenLoaded('tags', function() use ($locale) {
            return $this->tags->map(function($tag) use ($locale) {
                $tagTrans = $tag->trans->firstWhere('locale', $locale) ?? $tag->trans->first();
                return [
                    'id' => $tag->id,
                    'name' => $tagTrans->name ?? null,
                ];
            });
        });

        $paymentMethods = $this->whenLoaded('payment', function() use ($locale) {
            return $this->payment->map(function($method) use ($locale) {
                $methodTrans = $method->trans->firstWhere('locale', $locale) ?? $method->trans->first();
                return [
                    'id' => $method->id,
                    'name' => $methodTrans->name ?? null,
                    'key' => $method->payment_key,
                ];
            });
        });

        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'project_types' => $this->project_types,
            'location_type' => $this->location_type,
            'number' => $this->number,
            'beneficiary' => $this->beneficiary,
            'status' => $this->status,
            'featuer' => (bool)$this->featuer,
            'finished' => (bool)$this->finished,
            'recurring' => (bool)$this->recurring,
            'sort' => $this->sort,
            'donation_type' => $this->donation_type,
            'target_price' => (float)$this->target_price,
            'target_unit' => $this->target_unit,
            'fake_target' => (float)$this->fake_target,
            'collected_target' => (float)$this->collected_target,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'images' => $this->images ? json_decode($this->images) : [],
            'cover_image' => $this->cover_image ? url($this->cover_image) : null,
            'background_image' => $this->background_image ? url($this->background_image) : null,
            'background_color' => $this->background_color,
            'visits_count' => (int)$this->visits_count,
            'donations_count' => (int)$this->donations_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Translated fields
            'title' => $translation->title ?? null,
            'description' => $translation->description ?? null,
            'slug' => $translation->slug ?? null,
            'meta_title' => $translation->meta_title ?? null,
            'meta_description' => $translation->meta_description ?? null,
            'meta_keywords' => $translation->meta_key ?? null,
            'locale' => $translation->locale ?? null,
            
            // Relationships
            'category' => $category,
            'tags' => $tags,
            'payment_methods' => $paymentMethods,
            
            // Calculated fields
            'progress_percentage' => $this->target_price > 0 
                ? min(100, round(($this->collected_target / $this->target_price) * 100, 2))
                : 0,
            'remaining_days' => $this->end_date 
                ? max(0, now()->diffInDays($this->end_date, false))
                : null,
        ];
    }
}
