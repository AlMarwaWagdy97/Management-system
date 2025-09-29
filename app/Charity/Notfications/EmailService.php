<?php

namespace App\Charity\Notfications;

use App\Mail\NotifyMail;
use Mail;

class EmailService 
{


    /**
     * user email to which the Email will be sent .
     * @var string
     */
    protected $email;

    /**
     * subject gives in email                                                              
     * @var string
     */
    protected $subject;

    /**
     * message in email                                                                   
     * @var string
     */
    protected $message;



    /**
     * email constructor.
     *
     * @param string $email
     * @param string $subject
     * @param string $message
     */
    public function __construct($email, $subject, $message)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     *
     *  send Email 
     */
    public function send()
    {
        return Mail::to($this->email)->send(new NotifyMail($this->subject, $this->message));
    }

}
