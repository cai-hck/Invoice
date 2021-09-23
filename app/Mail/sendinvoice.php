<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendinvoice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    public $companyname;
    public $id;
    public $email;
    public function __construct($name,$companyname,$id,$email)
    {
        //
        $this->name = $name;
        $this->companyname = $companyname;
        $this->id = $id;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.sendinvoice')
                        ->from($this->email, $this->companyname)
                        ->subject($this->companyname.'-'.$this->id);
    }
}
