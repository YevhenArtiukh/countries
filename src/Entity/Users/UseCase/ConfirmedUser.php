<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 12:30
 */

namespace App\Entity\Users\UseCase;


use App\Core\Transaction;
use App\Entity\Users\UseCase\ConfirmedUser\Command;
use App\Entity\Users\Users;

class ConfirmedUser
{
    private $users;
    private $transaction;

    public function __construct(
        Users $users,
        Transaction $transaction
    )
    {
        $this->users = $users;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $existingUser = $this->users->findOneByToken($command->getToken());

        if(!$existingUser) {
            return;
        }

        $existingUser->confirmed();

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->userConfirmed();
    }
}