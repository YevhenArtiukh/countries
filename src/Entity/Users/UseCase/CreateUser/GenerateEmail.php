<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 12:00
 */

namespace App\Entity\Users\UseCase\CreateUser;


use App\Adapter\Core\EmailFactory;
use App\Entity\Users\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class GenerateEmail
{
    private $mailer;
    private $logger;
    private $emailFactory;
    private $urlGenerator;

    public function __construct(
        \Swift_Mailer $mailer,
        LoggerInterface $logger,
        EmailFactory $emailFactory,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
        $this->emailFactory = $emailFactory;
        $this->urlGenerator = $urlGenerator;
    }

    public function send(User $user)
    {
        $swiftMessage = $this->emailFactory->create(
            'Rejestracja',
            'users/add_generate_email.html.twig',
            [
                $user->getEmail()
            ],
            [
                'token' => $user->getToken()
            ]
        );

        try {
            $this->mailer->send($swiftMessage);
        } catch (\Throwable $e) {
            $this->logger->critical(
                sprintf('Error password-reset %s', $user->getId().'|'.$user->getName().'|'.$user->getSurname())
            );
            return;
        }
    }
}