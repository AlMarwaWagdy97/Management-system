<?php

namespace App\Charity\Gifts;

class Given
{
    /**
     * The name of the gifted
     * @var string
     */
    protected  $giver_name;

    /**
     * The mobile of the gifted
     * @var string
     */
    protected $giver_mobile;

    /**
     * The email of the gifted
     * @var string
     */
    protected $giver_email;

    /**
     * The address of the card.
     * @var string
     */
    protected $giver_address;

    /**
     * The message of the card.
     * @var string
     */
    protected $giver_message;


    /**
     * CartItem constructor.
     *
     * @param string $type
     * @param int|string $itemID
     * @param string $donation_type
     */
    public function __construct($data)
    {
        $this->giver_name = @$data['giver_name'];
        $this->giver_mobile = @$data['giver_mobile'];
        // $this->giver_email = $data['giver_email'];
        $this->giver_address = @$data['giver_address'];
        $this->giver_message = @$data['giver_message'];
    }

    public function getData(){
        return [
            'giver_name'      => $this->giver_name,
            'giver_mobile'    => $this->giver_mobile,
            // 'giver_email'     => $this->giver_email,
            'giver_address'   => $this->giver_address,
            'giver_message'   => $this->giver_message,
        ];
    }

    public function getJsonData(){
        return json_encode([
            'giver_name'      => $this->giver_name,
            'giver_mobile'    => $this->giver_mobile,
            // 'giver_email'     => $this->giver_email,
            'giver_address'  => $this->giver_address,
            'giver_message'  => $this->giver_message,
        ]);
    }

    public function getName()
    {
        return $this->giver_name;
    }
    public function getMobile()
    {
        return $this->giver_mobile;
    }
    public function getEmail()
    {
        return $this->giver_email;
    }
    public function getAddress()
    {
        return $this->giver_address;
    }
    public function getMessage()
    {
        return $this->giver_message;
    }
  
}
