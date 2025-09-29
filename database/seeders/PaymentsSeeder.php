<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->delete();
        DB::table('payment_method_translations')->delete();

        // $req = [
        //     $cod = [
        //         'en' => [
        //             'title' => 'COD',
        //         ],
        //         'ar' => [
        //             'title' => 'الدفع عند الاستلام',
        //         ],
        //     ],
        //     $visa = [
        //         'en' => [
        //             'title' => 'Visa',
        //         ],
        //         'ar' => [
        //             'title' => 'فيزا ',
        //         ],
        //     ],
        //     $bank = [
        //         'en' => [
        //             'title' => 'Bank Transfer',
        //         ],
        //         'ar' => [
        //             'title' => 'تحويل بنكي',
        //         ],
        //     ],
        // ];

        // if (PaymentMethod::query()->get()->count() == 0) {
        //     foreach ($req as $rq) {
        //         PaymentMethod::create($rq);
        //     }
        // }
    }
}
