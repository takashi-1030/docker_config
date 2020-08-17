<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RejectNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->title = sprintf('%s様のご予約をお受けできませんでした。',$name);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('mail/reject_mail')
                    ->subject($this->title);
    }
}
