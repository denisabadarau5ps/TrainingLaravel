<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Checkout extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $contacts;
    public $comments;
    public $products;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $contacts, $comments, $products)
    {
        $this->name = $name;
        $this->contacts = $contacts;
        $this->comments = $comments;
        $this->products = $products;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('checkout')->with([
            'name' => $this->name,
            'contacts' => $this->contacts,
            'comments' => $this->comments,
            'products' => $this->products,
        ]);
    }
}
