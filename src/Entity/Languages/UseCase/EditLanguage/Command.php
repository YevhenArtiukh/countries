<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 20:45
 */

namespace App\Entity\Languages\UseCase\EditLanguage;


use App\Entity\Languages\Language;

class Command
{
    private $language;
    private $name;
    private $responder;

    public function __construct(
        Language $language,
        string $name
    )
    {
        $this->language = $language;
        $this->name = $name;
        $this->responder = new NullResponder();
    }

    /**
     * @return Language
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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