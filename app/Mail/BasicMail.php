<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class BasicMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    public function __construct($args)
    {
        $this->data = $args;
    }

    public function build()
    {
        return $this->from("info@shop.mdisdo.org")
            ->subject($this->data['subject'])
            ->view('mail.basic-mail-template')->with('data', $this->data);
    }
}
