<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 20:24
 */

namespace App\Entity\Users\UseCase;



use App\Core\Transaction;
use App\Entity\Users\UseCase\EditUser\Command;

class EditUser
{
    private $transaction;

    public function __construct(
        Transaction $transaction
    )
    {
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $command->getUser()->edit(
            $command->getName(),
            $command->getSurname(),
            $command->getAge(),
            $command->getEmail(),
            $command->getRole(),
            $command->getLogin()
        );

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->userEdited();
    }
}