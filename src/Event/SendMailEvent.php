<?php
namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class SendMailEvent extends Event
{
    public const SEND_EMAIL = 'send.email';

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
