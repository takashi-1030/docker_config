<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Notification extends Mailable
{
    use Queueable, SerializesModels;

    protected $title;
    protected $date;
    protected $start;
    protected $number;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$date,$start,$number)
    {
        $this->title = sprintf('%s様 お申し込み完了メール',$name);
        $this->date = $date;
        $this->start = $start;
        $this->number = $number;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('mail/mail')
                    ->subject($this->title)
                    ->with([
                        'date' => $this->date,
                        'start' => $this->start,
                        'number' => $this->number
                    ]);
    }
}
