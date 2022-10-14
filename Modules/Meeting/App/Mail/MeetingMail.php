<?php

namespace Modules\Meeting\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MeetingMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public string $msg;
    public $subject;

    public function __construct($subject, $msg)
    {
        $this->msg = $msg;
        $this->subject = $subject;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): MeetingMail
    {
        return $this->from(env('MAIL_FROM_ADDRESS', 'noreply@softbdltd.com'))
            ->subject($this->subject)
            ->view('meeting::mail.meeting-mail');
    }
}
