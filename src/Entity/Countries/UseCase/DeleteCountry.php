<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 17:47
 */

namespace App\Entity\Countries\UseCase;


use App\Core\Transaction;
use App\Entity\Countries\Countries;
use App\Entity\Countries\UseCase\DeleteCountry\Command;

class DeleteCountry
{
    private $countries;
    private $transaction;

    public function __construct(
        Countries $countries,
        Transaction $transaction
    )
    {
        $this->countries = $countries;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $this->countries->delete($command->getCountry());

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->countryDeleted();
    }
}