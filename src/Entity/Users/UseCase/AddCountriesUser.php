<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 14:37
 */

namespace App\Entity\Users\UseCase;


use App\Core\Transaction;
use App\Entity\Users\UseCase\AddCountriesUser\Command;
use App\Entity\Users\Users;

class AddCountriesUser
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

        $command->getUser()->setCountries($command->getCountries());

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            throw $e;
        }

        $command->getResponder()->userCountriesEdited();
    }
}