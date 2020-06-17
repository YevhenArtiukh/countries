<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 12:26
 */

namespace App\Controller\Users;


use App\Entity\Users\UseCase\ConfirmedUser;
use App\Entity\Users\UseCase\ConfirmedUser\Responder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConfirmedController extends AbstractController implements Responder
{
    /**
     * @param string $token
     * @param Request $request
     * @param ConfirmedUser $confirmedUser
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Throwable
     * @Route("/confirmed/{token}", name="user_confirmed", methods={"GET"})
     */
    public function index(string $token, Request $request, ConfirmedUser $confirmedUser)
    {
        $command = new ConfirmedUser\Command(
            (string)$token
        );
        $command->setResponder($this);

        $confirmedUser->execute($command);

        return $this->redirectToRoute('login');
    }

    public function userConfirmed()
    {
        $this->addFlash('success', 'Konto aktywowane');
    }
}