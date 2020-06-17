<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 20:46
 */

namespace App\Entity\Languages\ReadModel;


class Language
{
    private $id;
    private $name;
    private $countCountry;

    public function __construct(
        int $id,
        string $name,
        int $countCountry
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->countCountry = $countCountry;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getCountCountry(): int
    {
        return $this->countCountry;
    }
}