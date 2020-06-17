<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 14:04
 */

namespace App\Entity\Countries\UseCase;


use App\Core\Transaction;
use App\Entity\Countries\Countries;
use App\Entity\Countries\Country;
use App\Entity\Countries\UseCase\CreateCountry\Command;
use App\Entity\Countries\UseCase\CreateCountry\UploadedFlag;
use App\Entity\Languages\Language;
use App\Entity\Languages\Languages;
use Doctrine\Common\Collections\ArrayCollection;

class CreateCountry
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

        $existingCountry = $this->countries->findOneByName($command->getName());

        if($existingCountry) {
            $command->getResponder()->countryExisted();
            return;
        }

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

        $country = new Country(
            $command->getName(),
            (new UploadedFlag($command->getFlag(), $this->targetDir))->move(),
            new ArrayCollection($languages??[])
        );

        foreach ($command->getUsers() as $user) {
            $country->addUser($user);
        }

        $this->countries->add($country);

        try {
            $this->transaction->commit();
        } catch (\Throwable $e) {
            $this->transaction->rollback();
            throw $e;
        }

        $command->getResponder()->countryCreated();
    }
}