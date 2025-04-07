<?php

namespace App\Mail;

use App\Models\FlotteSinistre;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewSinistreMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sinistre;

    public function __construct(FlotteSinistre $sinistre)
    {
        $this->sinistre = $sinistre;
    }

    public function build()
    {
        return $this->subject('Nouveau sinistre déclaré - ' . $this->sinistre->sinistre_num)
                    ->view('emails.new_sinistre')
                    ->with([
                        'sinistre' => $this->sinistre,
                    ]);
    }
}