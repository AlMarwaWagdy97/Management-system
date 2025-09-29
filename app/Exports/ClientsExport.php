<?php


namespace App\Exports;

use App\Models\Donor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ClientsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Donor::with(['orders' => fn($q)=>$q->orderBy('created_at','desc'), 'account','refer'])
                      ->whereHas('orders');

        if (!empty($this->filters['mobile'])) {
            $query->where('mobile','like','%'.$this->filters['mobile'].'%');
        }
        if (isset($this->filters['status'])) {
            $query->where('status',$this->filters['status']);
        }
        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereHas('orders', fn($q)=> 
                $q->whereBetween('created_at',[
                  $this->filters['start_date'],
                  $this->filters['end_date']
                ])
            );
        }
        if (!empty($this->filters['total_from'])) {
            $query->whereHas('orders', fn($q)=>
                $q->selectRaw('donor_id,sum(total) as sum_total')
                  ->groupBy('donor_id')
                  ->having('sum_total','>=',$this->filters['total_from'])
            );
        }
        if (!empty($this->filters['total_to'])) {
            $query->whereHas('orders', fn($q)=>
                $q->selectRaw('donor_id,sum(total) as sum_total')
                  ->groupBy('donor_id')
                  ->having('sum_total','<=',$this->filters['total_to'])
            );
        }

        // aggregates
        $query->withCount([
            'orders as paid_count'   => fn($q)=> $q->whereIn('status',[301,100]),
            'orders as unpaid_count' => fn($q)=> $q->whereNotIn('status',[301,100]),
        ])->withSum([
            'orders as paid_total'   => fn($q)=> $q->whereIn('status',[301,100]),
            'orders as unpaid_total' => fn($q)=> $q->whereNotIn('status',[301,100]),
        ], 'total');


        return $query->get()->map(function($d){
            $last = $d->orders->first();
            return [
                $d->full_name,
                "\t".$d->mobile,
                $d->account->email ?? '-',
                $d->created_at->format('Y-m-d'),
                $d->refer?->name ?? '-',
                number_format($d->orders->sum('total'),2),
                $d->paid_count,
                number_format($d->paid_total,2),
                $d->unpaid_count,
                number_format($d->unpaid_total,2),
                $last?->created_at->format('Y-m-d H:i:s') ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'الاسم',
            'رقم الجوال',
            'الإيميل',
            'تاريخ التسجيل',
            'المتجر',
            'إجمالي التبرع',
            'عدد مكتملة',
            'إجمالي مكتملة',
            'عدد غير مكتملة',
            'إجمالي غير مكتملة',
            'آخر تاريخ/وقت',
        ];
    }
}
