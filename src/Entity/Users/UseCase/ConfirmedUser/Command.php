<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 12:30
 */

namespace App\Entity\Users\UseCase\ConfirmedUser;


class Command
{
    private $token;
    private $responder;

    public function __construct(
        string $token
    )
    {
        $this->token = $token;
        $this->responder = new NullResponder();
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    public function getResponder(): Responder
    {
        return $this->responder;
    }

    public function setResponder(Responder $responder): self
    {
        $this->responder = $responder;

        return $this;
    }
}