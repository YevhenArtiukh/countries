<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 18:03
 */

namespace App\Entity\Countries\UseCase;


use App\Core\Transaction;
use App\Entity\Countries\Countries;
use App\Entity\Countries\UseCase\CreateCountry\UploadedFlag;
use App\Entity\Countries\UseCase\EditCountry\Command;
use App\Entity\Languages\Language;
use App\Entity\Languages\Languages;
use Doctrine\Common\Collections\ArrayCollection;

class EditCountry
{
    private $countries;
    private $languages;
    private $targetDir;
    private $transaction;

    public function __construct(
        Countries $countries,
        Languages $languages,
        string $targetDir,
        Transaction $transaction
    )
    {
        $this->countries = $countries;
        $this->languages = $languages;
        $this->targetDir = $targetDir;
        $this->transaction = $transaction;
    }

    public function execute(Command $command)
    {
        $this->transaction->begin();

        foreach ($command->getLanguages() as $language) {
            $existingLanguage = $this->languages->findOneByName($language);

            if(!$existingLanguage) {
                $existingLanguage = new Language(
                    $language
                );
                $this->languages->add($existingLanguage);
            }
            $languages[] = $existingLanguage;
        }

        $command->getCountry()->edit(
            $command->getName(),
            $command->getFlag()?(new UploadedFlag($command->getFlag(), $this->targetDir))->move():null,
            new ArrayCollection($languages??[])
        );

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->countryEdited();
    }
}