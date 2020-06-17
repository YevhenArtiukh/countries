<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 17:30
 */

namespace App\Entity\Countries\UseCase;


use App\Core\Transaction;
use App\Entity\Countries\UseCase\AcceptCountry\Command;

class AcceptCountry
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

        $command->getCountry()->accept();

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->countryAccepted();
    }
}