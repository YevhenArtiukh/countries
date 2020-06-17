<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 11:26
 */

namespace App\Entity\Users\UseCase\CreateUser;


final class NullResponder implements Responder
{
    public function userCreated()
    {

    }

    public function userExisted()
    {

    }
}