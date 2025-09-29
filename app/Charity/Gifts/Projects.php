<?php

namespace App\Charity\Gifts;

class Projects
{
    
    /**
     * The name of the gifted
     * @var string
     */
    protected  $item_id;

    /**
     * The item name of the gifted
     * @var string
     */
    protected $item_name;

    /**
     * The item sub type of the card.
     * @var string
     */
    protected $item_sub_type;

    /**
     * The price id .
     * @var string
     */
    protected $price;

    /**
     * The quantity of card.
     * @var string
     */
    protected $quantity;

    /**
     * CartItem constructor.
     *
     * @param string $type
     * @param int|string $itemID
     * @param string $donation_type
     */
    public function __construct($data)
    {
        $this->item_id = $data['item_id'];
        $this->item_name = $data['item_name'];
        $this->item_sub_type = $data['item_sub_type'];
        $this->price = $data['price'];
        $this->quantity = $data['quantity'];
    }

    
    public function getData(){
        return [
            'item_id'       => $this->item_id,
            'item_name'     => $this->item_name,
            'item_sub_type' => $this->item_sub_type,
            'price'         => $this->price,
            'quantity'      => $this->quantity,
        ];
    }

    public function getJsonData(){
        return json_encode([
            'item_id'       => $this->item_id,
            'item_name'     => $this->item_name,
            'item_sub_type' => $this->item_sub_type,
            'price'         => $this->price,
            'quantity'      => $this->quantity,
        ]);
    }

    public function getID()
    {
        return $this->item_id;
    }
    public function getName()
    {
        return $this->item_name;
    }
    public function getType()
    {
        return $this->item_sub_type;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }

}
