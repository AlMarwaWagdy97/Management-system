<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProjectExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $projects;

    public function __construct($projects)
    {
        $this->projects = $projects;
    }

    public function headings(): array
    {
        return [
            '#',
            'اسم المشروع',
            'رقم المشروع',
            'الاقسام',
            'تاريخ الإنشاء',
            'عدد الطلبات',
            'المجموع',
        ];
    }

    public function collection(): Collection
    {
        return $this->projects->map(function ($item) {
            return [
                $item->id,
                @$item->transNow?->title,
                $item->number,
                $item->categories->map(function ($category) {
                    return $category->transNow->title ?? $category->name ?? 'N/A';
                })->implode(', '),
                $item->created_at,
                $item->orderDetails?->count() ?? 0,
                $item->orderDetails?->sum('total') . ' ريال ',
            ];
        });
    }
}
