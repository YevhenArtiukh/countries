<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 15:15
 */

namespace App\Entity\Countries\ReadModel;


class Country
{
    private $id;
    private $name;
    private $flag;
    private $active;
    private $languages;
    private $countUsers;
    private $users;

    public function __construct(
        int $id,
        string $name,
        string $flag,
        bool $active,
        string $languages,
        int $countUsers,
        string $users
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->flag = $flag;
        $this->active = $active;
        $this->languages = $languages;
        $this->countUsers = $countUsers;
        $this->users = $users;
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
    public function getFlag(): string
    {
        return $this->flag;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return string
     */
    public function getLanguages(): string
    {
        return $this->languages;
    }

    /**
     * @return int
     */
    public function getCountUsers(): int
    {
        return $this->countUsers;
    }

    /**
     * @return string
     */
    public function getUsers(): string
    {
        return $this->users;
    }
}