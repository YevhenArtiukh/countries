<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 14:05
 */

namespace App\Entity\Countries\UseCase\CreateCountry;


final class NullResponder implements Responder
{

    public function countryCreated()
    {

    }

    public function countryExisted()
    {

    }
}