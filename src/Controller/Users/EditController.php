<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 20:30
 */

namespace App\Controller\Users;


use App\Entity\Users\UseCase\EditUser;
use App\Entity\Users\UseCase\EditUser\Responder;
use App\Entity\Users\User;
use App\Form\Users\EditType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param User $user
     * @param EditUser $editUser
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/user/{user}/edit", name="user_edit", methods={"GET", "POST"})
     */
    public function index(Request $request, User $user, EditUser $editUser)
    {
        if (!$this->isGranted(User::ROLE_ADMIN))
            throw $this->createAccessDeniedException();

        $form = $this->createForm(
            EditType::class,
            $this->transformData($user)
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new EditUser\Command(
                $user,
                (string)$data['login'],
                (string)$data['name'],
                (string)$data['surname'],
                (int)$data['age'],
                (string)$data['email'],
                (string)$data['role']
            );
            $command->setResponder($this);

            $editUser->execute($command);

            return $this->redirectToRoute('users');
        }

        return $this->render('users/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function transformData(User $user)
    {
        return [
            'login' => $user->getLogin(),
            'name' => $user->getName(),
            'surname' => $user->getSurname(),
            'age' => $user->getAge(),
            'email' => $user->getEmail(),
            'role' => $user->getRole()
        ];
    }

    public function userEdited()
    {
        $this->addFlash('success', 'Użytkownik został zmieniony');
    }
}