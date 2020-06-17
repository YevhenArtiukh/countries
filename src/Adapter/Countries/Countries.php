<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 10:29
 */

namespace App\Adapter\Countries;

use App\Entity\Countries\Countries as CountriesInterface;
use App\Entity\Countries\Country;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

class Countries implements CountriesInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(Country $country)
    {
        try {
            $this->entityManager->persist($country);
        } catch (ORMException $e) {
            throw $e;
        }
    }

    public function delete(Country $country)
    {
        try {
            $this->entityManager->remove($country);
        } catch (ORMException $e) {
            throw $e;
        }
    }

    /**
     * @param string $name
     * @return Country|null
     */
    public function findOneByName(string $name)
    {
        return $this->entityManager->getRepository(Country::class)->findOneBy([
            'name' => $name
        ]);
    }
}