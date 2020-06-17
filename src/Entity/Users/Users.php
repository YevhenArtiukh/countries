<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 10:38
 */

namespace App\Entity\Users;


interface Users
{
    public function add(User $user);

    public function delete(User $user);

    /**
     * @param string $login
     * @return User|null
     */
    public function findOneByLogin(string $login);

    /**
     * @param string $token
     * @return User|null
     */
    public function findOneByToken(string $token);
}