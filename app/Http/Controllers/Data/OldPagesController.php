<?php

namespace App\Http\Controllers\Data;

use App\Models\Pages;
use App\Models\Data\DataPages;
use App\Models\Data\DataPayments;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PaymentBank;

class OldPagesController extends Controller
{
    public function pages(){
        DB::beginTransaction();
        try{
            
            $pages = DataPages::get();

            foreach($pages as $page){
                $data = [
                    "ar" => [
                        'title' => $page->title,
                        'slug' => $page->alias,
                        'content' => $page->content,
                        'meta_description' => $page->meta_keywords,
                        'meta_key' => $page->meta_description,
                        'meta_title' => $page->name,
                    ],
                    // "en" => [
                    //     'title' => GoogleTranslate::trans($menu->name, "en"),
                    //     'slug' => GoogleTranslate::trans($menu->alias, "en"),
                    // ],
                    "image" => "attachments/pages/" .$page->image,
                    "status" => $page->status,
                ];
                Pages::create($data); 
                // dd($new_menu);
            }
            DB::commit();

        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
       return "All pages is updated";
    }


    public function bankAcounts(){
        DB::beginTransaction();
        try{
            $payments = DataPayments::where('payment_id', 1)->get()->first()->meta;
            $payments = json_decode($payments, true);
            foreach($payments as  $payment){
                PaymentBank::create([
                    'payment_method_id' => "3", 
                    'bank_name' => $payment['bankname'], 
                    'account_type' => $payment['account_type'], 
                    'iban' => $payment['iban'], 
                    'payment_key' => $payment['payment_key'], 
                    'bank_url' => $payment['url'], 
                    'image' => "attachments/PaymentMethod/" . $payment['image'], 
                ]);
            }
            DB::commit();

        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        return "All pages is updated";
    }
}
