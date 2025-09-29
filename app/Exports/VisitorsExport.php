<?php

namespace App\Exports;

use App\Models\Accounts;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VisitorsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Accounts::whereHas('donor.carts', function ($q) {
            $q->whereNotNull('item_id');
        })->whereDoesntHave('donor.orders');

        if (!empty($this->filters['mobile'])) {
            $query->where('mobile', 'like', '%' . $this->filters['mobile'] . '%');
        }
        if (!empty($this->filters['email'])) {
            $query->where('email', 'like', '%' . $this->filters['email'] . '%');
        }
      
        if (isset($this->filters['status']) && $this->filters['status'] !== '') {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('login_date', [
                $this->filters['start_date'],
                $this->filters['end_date'],
            ]);
        }

        $query = $query->with(['donor' => function ($q) {
            $q->select('id', 'account_id', 'full_name');
            $q->withCount(['carts' => function ($q2) {
                $q2->whereNotNull('item_id');
            }]);
        }]);

        $items = $query->get();

        return $items->map(function ($account) {
            return [
                'mobile' => "\t" . $account->mobile, // keep leading zeroes in Excel
                'full_name' => optional($account->donor)->full_name ?? '-',
                'email' => $account->email,
                'carts_count' => optional($account->donor)->carts_count ?? 0,
                'status' => $account->status ? 'نشط' : 'غير نشط',
                'created_at' => $account->created_at ? $account->created_at->format('Y-m-d') : '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'رقم الجوال',
            'اسم العميل',
            'البريد الإلكتروني',
            'عدد عناصر السلة',
            'الحالة',
            
            'تاريخ الإنشاء',
        ];
    }
}
