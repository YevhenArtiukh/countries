<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 18:03
 */

namespace App\Entity\Countries\UseCase\EditCountry;


use App\Entity\Countries\Country;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Command
{
    private $country;
    private $name;
    private $flag;
    private $languages;
    private $responder;

    public function __construct(
        Country $country,
        string $name,
        ?UploadedFile $flag,
        array $languages
    )
    {
        $this->country = $country;
        $this->name = $name;
        $this->flag = $flag;
        $this->languages = $languages;
        $this->responder = new NullResponder();
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return null|UploadedFile
     */
    public function getFlag(): ?UploadedFile
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