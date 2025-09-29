<?php

namespace App\Http\Controllers\Admin\Cms;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\PaymentMethodRequset;
use App\Models\PaymentBank;
use Illuminate\Support\Facades\DB;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $qurey = PaymentMethod::query()->with('trans')->orderBy('id', 'DESC');

        if ($request->status != '') {
            $qurey->where('status', $request->status);
        }

        if ($request->title != '') {
            $qurey->orWhereTranslationLike('title', '%' . $request->title . '%');
        }

        $payments = $qurey->paginate($this->pagination_count);

        return view('admin.dashboard.cms.payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dashboard.cms.payment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentMethodRequset $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->getSanitized();

            if ($request->hasFile('image')) {
                $data['image'] = $this->upload_file($request->file('image'), ('PaymentMethod'));
            }
            $payment = PaymentMethod::create($data);
            if (isset($data['banksList'])) {
                foreach ($data['banksList'] as $item) {
                    $bank = new PaymentBank();
                    $bank->payment_method_id    = $payment->id;
                    $bank->bank_name            = $item['bank_name'];
                    $bank->account_type         = $item['account_type'];
                    $bank->iban                 = $item['iban'];
                    $bank->payment_key          = $item['payment_key'];
                    $bank->bank_url             = $item['bank_url'];
                    if (isset($item['image']) && $item['image']) {
                        $item['image']  = $this->upload_file($item['image'], ('PaymentMethod'));
                        $bank->image    = $item['image'];
                    }
                    $bank->save();
                }
            }

            DB::commit();
            session()->flash('success', trans('message.admin.created_sucessfully'));
            if (request()->submit == "new") {
                return  redirect()->back();
            }

            return redirect()->route('admin.payment-method.index');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage() . ' ' . $e->getTraceAsString());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $paymentMethod)
    {
        return view('admin.dashboard.cms.payment.show', compact('paymentMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.dashboard.cms.payment.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentMethodRequset $request, PaymentMethod $paymentMethod)
    {
        DB::beginTransaction();
        try {
            $data = $request->getSanitized();
            if ($request->hasFile('image')) {
                $this->delete_file($paymentMethod->image);
                $data['image'] = $this->upload_file($request->file('image'), ('PaymentMethod'));
            }
            $paymentMethod->update($data);
            if (isset($data['banksList'])) {
                if (@$data['old'] != null) {
                    foreach (@$data['old']['id'] as $key => $old) {
                        $banks = PaymentBank::find($old);
                        $banks->bank_name = @$data['old']['bank_name'][$key];
                        $banks->account_type = @$data['old']['account_type'][$key];
                        $banks->iban = @$data['old']['iban'][$key];
                        $banks->payment_key = @$data['old']['payment_key'][$key];
                        $banks->bank_url = @$data['old']['bank_url'][$key];
                        if (isset($data['old']['image']) && @$data['old']['image'][$key]) {
                            $banks->image  = $this->upload_file($data['old']['image'][$key], 'PaymentMethod', $key);
                        }
                        $banks->save();
                    }
                }
                PaymentBank::query()->whereIn('id', $paymentMethod->banks->pluck('id')->toArray())->WhereNotIN('id', @$data['old']['id']  ?? [])->delete();
                if ($paymentMethod->banks != null) {
                    foreach ($data['banksList'] as $item) {
                        if ($item['bank_name'] != null || $item['account_type'] != null || $item['iban'] != null || $item['payment_key'] || $item['bank_url']) {
                            if (isset($item['image']) && $item['image']) {
                                $item['image']  = $this->upload_file($item['image'], 'PaymentMethod', $key + 100);
                            }
                            PaymentBank::create([
                                'bank_name'         => $item['bank_name'],
                                'account_type'      => $item['account_type'],
                                'iban'              => $item['iban'],
                                'payment_key'       => $item['payment_key'],
                                'bank_url'          => $item['bank_url'],
                                'payment_method_id' => $paymentMethod->id,
                                'image'             =>  $item['image'],
                            ]);
                        }
                    }
                }
                session()->flash('success', trans('message.admin.updated_sucessfully'));
            }

            DB::commit();
            session()->flash('success', trans('message.admin.updated_sucessfully'));
            if (request()->submit == "update") {
                return  redirect()->back();
            }
            return redirect()->route('admin.payment-method.index');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage() . ' ' . $e->getTraceAsString());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        $this->delete_file($paymentMethod->image);
        $paymentMethod->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    // Update Status 

    public function update_status($id)
    {
        $payment = PaymentMethod::findOrfail($id);
        $payment->status == 1 ? $payment->status = 0 : $payment->status = 1;
        $payment->save();
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }

    // method Action All cheaked delete and updated staus
    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $payments = PaymentMethod::findMany($request['record']);
            foreach ($payments as $payment) {
                $payment->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $payments = PaymentMethod::findMany($request['record']);
            foreach ($payments as $payment) {
                $payment->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $payments = PaymentMethod::findMany($request['record']);
            foreach ($payments as $payment) {
                $this->delete_file($payment->image);
                $payment->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
