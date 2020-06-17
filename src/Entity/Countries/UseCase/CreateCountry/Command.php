<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 14:05
 */

namespace App\Entity\Countries\UseCase\CreateCountry;


use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Command
{
    private $name;
    private $flag;
    private $languages;
    private $users;
    private $responder;

    public function __construct(
        string $name,
        UploadedFile $flag,
        array $languages,
        Collection $users
    )
    {
        $this->name = $name;
        $this->flag = $flag;
        $this->languages = $languages;
        $this->users = $users;
        $this->responder = new NullResponder();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return UploadedFile
     */
    public function getFlag(): UploadedFile
    {
        return $this->flag;
    }

    /**
     * @return array
     */
    public function getLanguages(): array
    {
        return $this->languages;
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
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