<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 20:45
 */

namespace App\Entity\Languages\UseCase;


use App\Core\Transaction;
use App\Entity\Languages\Languages;
use App\Entity\Languages\UseCase\EditLanguage\Command;

class EditLanguage
{
    private $languages;
    private $transaction;

    public function __construct(
        Languages $languages,
        Transaction $transaction
    )
    {
        $this->languages = $languages;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        $command->getLanguage()->edit(
            $command->getName()
        );

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            throw $e;
        }

        $command->getResponder()->languageEdited();
    }
}