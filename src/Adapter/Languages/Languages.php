<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 16:50
 */

namespace App\Adapter\Languages;

use App\Entity\Languages\Language;
use App\Entity\Languages\Languages as LanguagesInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

class Languages implements LanguagesInterface
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function add(Language $language)
    {
        try {
            $this->entityManager->persist($language);
        } catch (ORMException $e) {
            throw $e;
        }
    }

    /**
     * @param string $name
     * @return Language|null
     */
    public function findOneByName(string $name)
    {
        return $this->entityManager->getRepository(Language::class)->findOneBy([
            'name' => $name
        ]);
    }
}