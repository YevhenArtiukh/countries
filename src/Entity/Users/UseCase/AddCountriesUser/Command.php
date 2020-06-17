<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 14:38
 */

namespace App\Entity\Users\UseCase\AddCountriesUser;


use App\Entity\Users\User;
use Doctrine\Common\Collections\Collection;

class Command
{
    private $user;
    private $countries;
    private $responder;

    public function __construct(
        User $user,
        Collection $countries
    )
    {
        $this->user = $user;
        $this->countries = $countries;
        $this->responder = new NullResponder();
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Collection
     */
    public function getCountries(): Collection
    {
        return $this->countries;
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