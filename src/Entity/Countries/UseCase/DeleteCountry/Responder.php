<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 17:47
 */

namespace App\Entity\Countries\UseCase\DeleteCountry;


interface Responder
{
    public function countryDeleted();
}