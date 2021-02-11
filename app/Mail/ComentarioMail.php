<?php

namespace App\Mail;

use App\Models\Comentario;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComentarioMail extends Mailable
{
    use MailTrait;
    use Queueable, SerializesModels;

    public $comentario;
    public $chamado;
    public $autor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comentario $comentario)
    {
        $this->comentario = $comentario;
        $this->chamado = $comentario->chamado;
        $this->autor = $this->chamado->users()->wherePivot('papel', 'Autor')->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject($this->construirAssunto())
            ->view('emails.novo_comentario');
    }
}
