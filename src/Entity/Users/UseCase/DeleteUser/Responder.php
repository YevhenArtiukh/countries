<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 20:00
 */

namespace App\Entity\Users\UseCase\DeleteUser;


interface Responder
{
    public function userDeleted();
}