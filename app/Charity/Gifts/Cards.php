<?php

namespace App\Charity\Gifts;

class Cards
{

    /**
     * The occasion of the card.
     * @var string
     */
    protected $occasion;

    /**
     * The category of the card.
     * @var string
     */
    protected $category;

    /**
     * The occasion name of the card.
     * @var string
     */
    protected $occasionName;

    /**
     * The category name of the card.
     * @var string
     */
    protected $categoryName;

    /**
     * The card id .
     * @var string
     */
    protected $card;

    /**
     * The card id .
     * @var string
     */
    protected $cardImage;


    /**
     * CartItem constructor.
     *
     * @param string $type
     * @param int|string $itemID
     * @param string $donation_type
     */
    public function __construct($data)
    {
        $this->occasion = $data['occasion'];
        $this->category = $data['category'];
        $this->occasionName = $data['occasionName'];
        $this->categoryName = $data['categoryName'];
        $this->card = $data['card'];
        $this->cardImage = $data['cardImage'];
    }

    public function getData(){
        return [
            'occasion' => $this->occasion,
            'category' => $this->category,
            'occasionName' => $this->occasionName,
            'categoryName' => $this->categoryName,
            'card' => $this->card,
            'cardImage' => $this->cardImage,
        ];
    }

    public function getJsonData(){
        return json_encode([
            'occasion' => $this->occasion,
            'category' => $this->category,
            'occasionName' => $this->occasionName,
            'categoryName' => $this->categoryName,
            'card' => $this->card,
            'cardImage' => $this->cardImage,
        ]);
    }

 
    public function getOccasion()
    {
        return $this->occasion;
    }
    public function getCategory()
    {
        return $this->category;
    }
    public function getoccasionName()
    {
        return $this->occasionName;
    }
    public function getcategoryName()
    {
        return $this->categoryName;
    }
    public function getCard()
    {
        return $this->card;
    }
    public function getcardImage()
    {
        return $this->cardImage;
    }

}
