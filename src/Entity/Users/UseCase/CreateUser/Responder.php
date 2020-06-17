<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 11:25
 */

namespace App\Entity\Users\UseCase\CreateUser;


interface Responder
{
    public function userCreated();
    public function userExisted();
}