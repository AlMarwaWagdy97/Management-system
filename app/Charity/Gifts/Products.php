<?php

namespace App\Charity\Gifts;

class Products
{
    /**
     * The category of the card.
     * @var string
     */
    protected $category;

    /**
     * The card id .
     * @var string
     */
    protected $card;

    /**
     * The price of card.
     * @var string
     */
    protected $price;

    /**
     * CartItem constructor.
     *
     * @param string $type
     * @param int|string $itemID
     * @param string $donation_type
     */
    public function __construct($data)
    {
        $this->category = $data['category'];
        $this->card = $data['card'];
        $this->price = $data['price'];
    }

    

    public function getCategory()
    {
        return $this->category;
    }
    public function getCard()
    {
        return $this->card;
    }
    public function getPrice()
    {
        return $this->price;
    }

}
