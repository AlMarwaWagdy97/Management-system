<?php


namespace App\Charity\Carts;

interface CartInterface
{
    /**
     * Add an item to the cart.
     *
     * @param Item $item
     * @param int $quantity
     * @param float $price
     * @param string $giftInfo
     *
     * @return array|message
     */
    public function addItem(Item $item, $quantity = 1, $price = 1, $giftInfo);
    
    /**
     * get all items from the cart.
     * @return array|CartItem
    */
    public function getItems();
    
    /**
     * remove item from the cart.
     *
     * @param string|int $itemId
     * @return null
     */
    public function removeItem($itemId);


    /**
     * empty all items from the cart.
     *
     * @return null
    */
    public function empty();

    /**
     * minus item quantity from the cart.
     *
     * @param string|int $itemId
     * @return null
    */
    public function minusItem($itemId);

    /**
     * plus item quantity from the cart.
     *
     * @param string|int $itemId
     * @return null
    */
    public function plusItem($itemId);

    // public function updateQuantity($itemId, $quantity);

    // public function getTotalItems();

    // public function getTotalPrice();
}



