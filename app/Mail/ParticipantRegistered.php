<?php

namespace App\Mail; 

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class ParticipantRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $participant;
    public $qrPath;

    /**
     * Create a new message instance.
     */
    public function __construct($event, $participant, $qrPath)
    {
        $this->event = $event;
        $this->participant = $participant;
        $this->qrPath = $qrPath;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $mail = $this->markdown('emails.participant.registered')
                    ->subject('Conferma registrazione evento: '.$this->event->title)
                    ->with([
                        'event' => $this->event,
                        'participant' => $this->participant,
                    ]);
        
        // Allega il QR code se esiste
        if (file_exists($this->qrPath)) {
            $mail->attach($this->qrPath, [
                'as' => 'qr_code.png',
                'mime' => 'image/png',
            ]);
        }
        
        return $mail;
    }
}
