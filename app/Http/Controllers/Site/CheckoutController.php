<?php

namespace App\Http\Controllers\Site;

use App\Models\Order;
use App\Enums\SourcesEnum;
use App\Models\OrderDetails;
use App\Charity\Carts\DatabaseCart;
use App\Charity\Settings\SettingSingleton;
use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\CharityProject;
use App\Models\Donor;
use App\Models\Giver;
use App\Models\LoginTypes;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{


    /**
     * checkout page
     */
    public function index(Request $request)
    {
        $cart = new DatabaseCart();
        $cart = $cart->getItems();
        if ($cart->first() == null) {
            session()->flash('warning', __('Empty Cart'));
            return  redirect()->route('site.home');
        }
        session()->flash('warning', optional($request)->msg);
        return view('site.pages.checkout.index');
    }


    /**
     * check out  function : insert cart to order and order details
     *
     * input [array] cart
     */
    public function process($data)
    {
        DB::beginTransaction();
        try {
            $cart = new DatabaseCart();
            $cartItems = $cart->getItemsWithInfo();
            if ($cartItems['total'] == 0) {
                return [
                    'status' => false,
                    'message' => __("No item in cart"),
                ];
            }

            if ($missingItemId = $this->checkMissingData($cartItems)) {
                return [
                    'status' => false,
                    'message' => __("Please fill missing data"),
                    'data' => [
                        'missData' => $missingItemId,
                    ],
                ];
            }
            // create order
            $data['total']          = $cartItems['total'];
            $data['quantity']       = $cartItems['quantity'];
            $data['source']         = SourcesEnum::WEB;
            $data['donor_id']       = @auth()->user()?->donor->id;
            $data['refer_id']       =  @auth()->user()?->donor->refer_id ?? 1; //change to donor table refarier id 

            $order = Order::create($data);

            // update identifier
            $order->identifier = orderIdentifier($order->id);
            $order->save();

            // create order items
            foreach ($cartItems['cart'] as $item) {
                $cartItem = OrderDetails::create([
                    'order_id'          => $order->id,
                    'item_type'         => $item->item_type,
                    'item_id'           => $item->item_id,
                    'item_name'         => $item->item_name,
                    'item_sub_type'     => $item->item_sub_type,
                    'quantity'          => $item->quantity,
                    'price'             => $item->price,
                    'total'             => $item->quantity * $item->price,
                    'gift_details'      => $item->gift_details,
                    'is_gift'           => $item->gift_details ? 1 : 0,
                    'vendor_id'         => @$item->vendor_id,
                    'order_details_id'  => @$item->id,
                ]);
                // if order has gifen data
                if ($item->givten_details) {
                    $given_details = json_decode($item->givten_details);
                    $given_card = json_decode($item->gift_card_details);
                    Giver::create([
                        'order_id'          => $cartItem->id,
                        'name'              => $given_details->giver_name,
                        'mobile'            => $given_details->giver_mobile,
                        'message'           => @$given_details->giver_message,
                        'address'           => $given_details->giver_address,

                        'category_id'       => @$given_card->category,
                        'occasioin_id'      => @$given_card->occasion,
                        'category_name'     => @$given_card->categoryName,
                        'occasioin_name'    => @$given_card->occasionName,
                        'card_id'           => @$given_card->card,
                        'image'             => @$given_card->cardImage,
                    ]);
                }

                // if order has gift project details
                if ($item->gift_projects_details) {
                    $projectData = json_decode($item->gift_projects_details);
                    $ddd = OrderDetails::create([
                        'order_id'          => $order->id,
                        'order_details_id'  => $cartItem->id,
                        'item_type'         => CharityProject::class,
                        'item_id'           => $projectData->item_id,
                        'item_name'         => $projectData->item_name,
                        'item_sub_type'     => $projectData->item_sub_type,
                        'quantity'          => $projectData->quantity,
                        'price'             => $projectData->price,
                        'total'             => $projectData->quantity * $projectData->price,
                        'gift_details'      => $item->gift_details,
                        'vendor_id'         => @$item->vendor_id,
                    ]);
                    $order->total = $order->total + $projectData->price;
                    $order->quantity = $order->quantity + 1;
                    $order->save();
                }
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        return [
            'status' => true,
            'order' =>  $order,
            'message' => __("Order create Sucessfully"),
        ];
    }


    /**
     * check missing data
     */
    public function checkMissingData($data)
    {
        $products = $data['cart']->where('item_type', 'App\Models\Product')->where('givten_details', null);
        if (!empty($products->first())) {
            return $products->first()->id;
        }
    }


    /**
     * successfully place order view [sucessfully created]
     */
    public function success($identifier)
    {
        $order = Order::where('identifier', $identifier)->get()->first();
        // $cart = new DatabaseCart();
        // $cart = $cart->getItems();
        // if ($cart->first() == null) {
        //     return  redirect()->route('site.home');
        // }
        // Cookie::queue('cart', "");
        // Cookie::queue(Cookie::forget('cart'));
        // session()->flash('success', __('Your request has been successfully received and is being reviewed'));
        $settings = SettingSingleton::getInstance();

        return view('site.pages.checkout.success', compact('settings', 'order'));
    }


    /**
     * check out of the fast donation
     */
    public function fastDonationProcess($data)
    {
        DB::beginTransaction();
        try {
            // create or get donor info
            $donor = Donor::with('account')->where('mobile', $data['mobile'])->get()->first();
            if (!$donor) {
                $account = Accounts::create(['mobile' => $data['mobile']]);
                $types = LoginTypes::query()->whereIn('type', ['donor'])->pluck('id')->toArray();
                $account->types()->attach($types);
                $donor = Donor::with('account')->create([
                    'account_id' => $account->id,
                    'full_name'  => $data['name'],
                    'mobile'     => $data['mobile'],
                ]);
            }
            $data['donor_id'] = @$donor->id;

            // create order
            $order = Order::create($data);

            // create order items
            OrderDetails::create([
                'order_id'      => $order->id,
                'item_type'     => CharityProject::class,
                'item_id'       => $data['item_id'],
                'item_name'     => $data['item_name'],
                'item_sub_type' => @$data['item_type'],
                'quantity'      => $data['quantity'],
                'price'         => $data['total'],
                'total'         => $data['total'] * $data['quantity'],
                'order_details_id'  => @$data['item_id'],
            ]);

            // update identifier
            $order->identifier = orderIdentifier($order->id);
            $order->save();

         
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }

        return [
            'status' => true,
            'order' =>  $order,
            'message' => __("Order create Sucessfully"),
        ];
    }


    /**
     * successfully place order view [sucessfully created]
     */
    public function applepayView($identifier)
    {

        $order = Order::where("identifier", $identifier)->get()->first();

        return view('site.pages.checkout.applepay', compact('order'));
    }
}
