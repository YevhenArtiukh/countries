<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 11:25
 */

namespace App\Entity\Users\UseCase;


use App\Core\Transaction;
use App\Entity\Users\UseCase\CreateUser\Command;
use App\Entity\Users\UseCase\CreateUser\GenerateEmail;
use App\Entity\Users\User;
use App\Entity\Users\Users;

class CreateUser
{
    private $users;
    private $generateEmail;
    private $transaction;

    public function __construct(
        Users $users,
        GenerateEmail $generateEmail,
        Transaction $transaction
    )
    {
        $this->users = $users;
        $this->generateEmail = $generateEmail;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $existingLogin = $this->users->findOneByLogin($command->getLogin());

        if($existingLogin) {
            $command->getResponder()->userExisted();
            return;
        }

        $user = new User(
            $command->getName(),
            $command->getSurname(),
            $command->getAge(),
            $command->getEmail(),
            $command->getLogin(),
            $command->getPassword(),
            rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=')
        );

        $this->users->add($user);

        $this->generateEmail->send($user);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            throw $e;
        }

        $command->getResponder()->userCreated();
    }
}