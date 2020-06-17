<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 12:00
 */

namespace App\Adapter\Core;


use Twig\Environment;

final class EmailFactory
{
    private $templating;
    private $from;

    public function __construct(
        Environment $templating,
        string $from
    )
    {
        $this->templating = $templating;
        $this->from = $from;
    }

    public function create(
        string $subject,
        string $template,
        array $users,
        array $parameters
    )
    {
        $swiftMessage = new \Swift_Message();
        $swiftMessage->setSubject($subject);

        $html = $this->templating->render($template, $parameters);

        $swiftMessage
            ->setBody($html,'text/html')
            ->setFrom($this->from, 'myStart')
            ->setTo($users);

        return $swiftMessage;
    }
}