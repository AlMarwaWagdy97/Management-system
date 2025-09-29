<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrderDetailsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }


    public function headings(): array
    {
        return [
            'رقم الطلب',
            'رقم التبرع',
            'اسم العميل',
            'الايميل',
            'جوال العميل',
            'اسم المنتج',
            'الكمية',
            'السعر',
            'الإجمالي',
            'حالة الشحن',
            'التاريخ',
            'البائع',
        ];
    }

    public function collection(): Collection
    {
        return $this->orders->map(function ($detail) {
            return [
                $detail->id,
                $detail->order->id ?? '—',
                $detail->order?->donor?->full_name ?? '—',
                $detail->order?->donor?->account->email ?? '—',
               "\t". $detail->order?->donor?->mobile ?? '—',
                $detail->item_name,
                $detail->quantity,
                number_format($detail->price ?? 0, 2),
                number_format($detail->total ?? 0, 2),
                $detail->shipping_status,
                optional($detail->created_at)->format('d-m-Y H:i:s'),
                $detail->vendor?->name ?? '—',
            ];
        });
    }



   
}
