<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 19:59
 */

namespace App\Controller\Users;


use App\Entity\Users\UseCase\DeleteUser;
use App\Entity\Users\UseCase\DeleteUser\Responder;
use App\Entity\Users\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param User $user
     * @param DeleteUser $deleteUser
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Throwable
     * @Route("/user/{user}/delete", name="user_delete", methods={"DELETE"})
     */
    public function index(Request $request, User $user, DeleteUser $deleteUser)
    {
        if ($this->isCsrfTokenValid('delete' . (int)$user->getId(), $request->request->get('_token')) and $this->isGranted(User::ROLE_ADMIN)) {

            $command = new DeleteUser\Command(
                $user
            );
            $command->setResponder($this);

            $deleteUser->execute($command);
        }

        return $this->redirectToRoute('users');
    }

    public function userDeleted()
    {
        $this->addFlash('success', 'Użytkownik został usunięty');
    }
}