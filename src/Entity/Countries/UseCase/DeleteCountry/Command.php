<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 17:47
 */

namespace App\Entity\Countries\UseCase\DeleteCountry;


use App\Entity\Countries\Country;

class Command
{
    private $country;
    private $responder;

    public function __construct(
        Country $country
    )
    {
        $this->country = $country;
        $this->responder = new NullResponder();
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
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