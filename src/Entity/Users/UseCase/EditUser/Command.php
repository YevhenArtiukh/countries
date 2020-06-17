<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 20:24
 */

namespace App\Entity\Users\UseCase\EditUser;


use App\Entity\Users\User;

class Command
{
    private $user;
    private $login;
    private $name;
    private $surname;
    private $age;
    private $email;
    private $role;
    private $responder;

    public function __construct(
        User $user,
        string $login,
        string $name,
        string $surname,
        int $age,
        string $email,
        string $role
    )
    {
        $this->user = $user;
        $this->login = $login;
        $this->name = $name;
        $this->surname = $surname;
        $this->age = $age;
        $this->email = $email;
        $this->role = $role;
        $this->responder = new NullResponder();
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
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
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    public function getResponder(): Responder
    {
        return $this->responder;
    }

    public function setResponder(Responder $responder): self
    {
        $this->responder = $responder;

        return $this;
    }
}