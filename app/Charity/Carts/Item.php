<?php

namespace App\Charity\Carts;

class Item
{
    /**
     * The type of the item (Project, product, badal, Descesed, ...).
     * @var string
     */
    protected $type;

    /**
     * The ID of the item .
     * @var string
     */
    protected $itemID;

    /**
     * The donation type of the item .
     * @var string
     */
    protected $donation_type;


    /**
     * CartItem constructor.
     *
     * @param string $type
     * @param int|string $itemID
     * @param string $donation_type
     */
    public function __construct($type, $itemID, $donation_type)
    {
        $this->type = $type;
        $this->itemID = $itemID;
        $this->donation_type = $donation_type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getItemId()
    {
        return $this->itemID;
    }

    public function getDonationType()
    {
        return $this->donation_type;
    }

    public function getItemName()
    {
        $path =  $this->type;
        $model = new $path();
        $itemModel = $model->find($this->itemID);
        return  $itemModel->trans?->where('locale', app()->getLocale())?->first()->title;
    }
}
