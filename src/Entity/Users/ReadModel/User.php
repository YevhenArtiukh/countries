<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 13:12
 */

namespace App\Entity\Users\ReadModel;


class User
{
    private $id;
    private $name;
    private $surname;
    private $email;
    private $age;
    private $countries;

    public function __construct(
        int $id,
        string $name,
        string $surname,
        string $email,
        int $age,
        int $countries
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->age = $age;
        $this->countries = $countries;
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
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @return int
     */
    public function getCountries(): int
    {
        return $this->countries;
    }
}