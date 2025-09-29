<?php

namespace App\Charity\Carts;

use App\Models\Cart;
use Illuminate\Support\Str;
use App\Charity\Carts\CartInterface;
use App\Models\CharityProject;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class DatabaseCart implements CartInterface
{

    /**
     * add item too cart
     * 
     * @param Item $item
     * @param int $quantity
     * @param float $price
     * @param string $giftInfo (nullable)
     * 
     * @return void
     */
    public function addItem($item, $quantity = 1, $price = 0, $giftIfo = NULL, $new = false) 
    {
        //validate donation price: 
        if($price <= 0 ){
            return  [
                'type' => 'warning',
                'value' => __('The donation value must be greater than zero'),
            ];
        }
        //validate donation amount: 
        if($quantity <= 0 ){
            return  [
                'type' => 'warning',
                'value' => __('Please provide a valid donation quantity')
            ];
        }

        $cookieValue = Cookie::get('cart');
        if(!$cookieValue){
            $token = Str::random(32); // Adjust the length as needed
            $cookieValue = Cookie::make('cart', $token, 60 * 24 * 365);
        }
    
        if($giftIfo == NULL && !$new){
            // check if item in the cart 
            $cart = Cart::where('cookeries', $cookieValue)
                ->where('item_name' , $item->getItemName())
                ->where('item_type' , $item->getType())
                ->where('item_id' , $item->getItemId())
                ->where('item_sub_type', $item->getDonationType())
                ->where('price',  $price)->get()->first();
        }else{
            $cart = "";
        }
        // if($item->getType() == CharityProject::class){
            // dd( $this->getVendor( $item->getType(), $item->getItemId() ) );

            if(!$cart){  // create item 
                $cart = Cart::create([
                    'item_type'         => $item->getType(),
                    'item_id'           => $item->getItemId(),
                    'item_name'         => $item->getItemName(),
                    'item_sub_type'     => $item->getDonationType(),
                    'cookeries'         => $cookieValue,
                    'quantity'          => $quantity,
                    'price'             => $price,
                    'gift_details'      => json_encode($giftIfo),
                    'vendor_id'         => $this->getVendor( $item->getType(), $item->getItemId()),
                    'donor_id'          => @auth('account')->user()?->donor->id,
                ]);
            }else{  // update item 
                $cart->quantity = $cart->quantity + $quantity;
                $cart->gift_details = $giftIfo ;
                $cart->save();
            }

            $message = [
                'card_id'   => $cart->id,
                'type'      => 'success',
                'value'     => trans('The project has been successfully added to the donation basket')
            ];
        // }
        
        return $message;
    }

    public function addGivtenCard($card_id, $data){
        $cart =  Cart::find($card_id);
        $cart->givten_details = json_encode($data);
        $cart->save();
       return 1;
    }

    /**
     * Adds gift card details to the specified cart item.
     */
    public function addGiftCard($card_id, $data)
    {
        $cart =  Cart::find($card_id);
        $cart->gift_card_details = json_encode($data);
        $cart->save();
       return 1;
    }

    public function addProjectToCard($card_id, $data){
        $cart =  Cart::find($card_id);
        $cart->gift_projects_details = json_encode($data);
        $cart->save();
       return 1;
    }

    public function addProductCard($card_id, $data){
       return  Cart::find($card_id)->update('gift_products_details', $data);
    }
    public function addProjectCard($card_id, $data){
       return  Cart::find($card_id)->update('gift_projects_details', $data);
    }

    /**
     * conect project to product
     */
    public function connectProjectToProduct($main_id, $sub_id)
    {
        $cart =  Cart::find($sub_id);
        $cart->cart_id = $main_id;
        $cart->save();
       return 1;
    }

    public function getItems(){
        $cookieValue = Cookie::get('cart');
        return Cart::with(['item', 'item.trans'])->where('cookeries', $cookieValue)->get();
    }

    public function getItemsWithInfo(){
        $cookieValue = Cookie::get('cart');
        $cart = Cart::with('item', 'item.trans')->where('cookeries', $cookieValue);
        return [
            'cart' => clone $cart->get(),
            'total'=> $cart->selectRaw('SUM(price * quantity) as total')->value('total'),
            'quantity'=> $cart->sum('quantity'),
        ];
    }

    public function removeItem($cartID){
        $cart = Cart::find($cartID);
        $cart->delete();
    }

    public function empty(){
        $cookieValue = Cookie::get('cart');
        Cart::where('cookeries', $cookieValue)->delete();
    }

    public function minusItem ($id){
        $cart = Cart::find($id);
        if($cart->quantity > 1){
            $cart->quantity = $cart->quantity - 1;
            $cart->save();
        }
    }  

    public function plusItem($id){
        $cart = Cart::find($id);
        $cart->quantity = $cart->quantity + 1;
        $cart->save();
    }


    public function updateQuantity($productId, $quantity){}


    public function getTotalItems(){}

    public function getTotalPrice(){}


    public function getVendor($type, $id){
        if($type == Product::class){
            return Product::find($id)->vendor_id;
        }
        return null;
    }


    public function updateDonor(){
        $cookieValue = Cookie::get('cart');
        $donor_id = @auth('account')->user()?->donor->id;
        $cart = Cart::where('cookeries', $cookieValue)->update(['donor_id' => $donor_id]);
        return $cart;
    }

}

