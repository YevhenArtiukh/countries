<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 11:36
 */

namespace App\Adapter\Users;

use App\Entity\Users\User;
use App\Entity\Users\Users as UsersInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

class Users implements UsersInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(User $user)
    {
        try {
            $this->entityManager->persist($user);
        } catch (ORMException $e) {
            throw new $e;
        }
    }

    public function delete(User $user)
    {
        try {
            $this->entityManager->remove($user);
        } catch (ORMException $e) {
            throw $e;
        }
    }

    /**
     * @param string $login
     * @return User|null
     */
    public function findOneByLogin(string $login)
    {
        return $this->entityManager->getRepository(User::class)->findOneBy([
            'login' => $login
        ]);
    }

    /**
     * @param string $token
     * @return User|null
     */
    public function findOneByToken(string $token)
    {
        return $this->entityManager->getRepository(User::class)->findOneBy([
            'token' => $token
        ]);
    }
}