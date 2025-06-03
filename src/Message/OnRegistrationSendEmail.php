<?php
namespace App\Message;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class OnRegistrationSendEmail
{
     private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
