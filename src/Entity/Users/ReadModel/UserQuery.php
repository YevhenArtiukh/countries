<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 13:12
 */

namespace App\Entity\Users\ReadModel;


interface UserQuery
{
    /**
     * @return mixed
     */
    public function findAll();

    /**
     * @param int $id
     * @return User|null
     */
    public function findOneById(int $id);
}