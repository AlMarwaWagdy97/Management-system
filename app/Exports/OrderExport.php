<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrderExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function headings(): array
    {
        return [
            'رقم التبرع',
            'اسم العميل',
            'رقم العميل',
            'المبلغ',
            'وسيلة الدفع',
            'الحالة',
            'تاريخ الإنشاء',
            'الساعة',
        ];
    }

    public function collection(): Collection
    {
        return $this->orders->map(function ($order) {
            return [
                $order->id,
                $order->donor ? $order->donor->full_name : '—',
                "\t" . ($order->donor ? $order->donor->mobile : '—'),
                number_format($order->total ?? 0, 2),
                $order->paymentMethodTranslationAr?->title ?? '—',
                $order->status == 1 ? 'مكتمل' : 'غير مكتمل',
                optional($order->created_at)->format('Y-m-d'),
                optional($order->created_at)->format('H:i:s'),
            ];
        });
    }
}
