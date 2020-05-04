<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserWelcome extends Mailable
{
    use Queueable, SerializesModels;

    private array $user;

    /**
     * UserWelcome constructor.
     * @param array $user
     */
    public function __construct($user = [])
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user.welcome', [
            "name" => $this->user[0] ?? '马邦德',
            "sex" => ($this->user[1] ?? "女") == "女" ? "欧巴桑" : "欧尼酱"
        ]);
    }
}
