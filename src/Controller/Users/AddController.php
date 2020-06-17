<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 11:00
 */

namespace App\Controller\Users;


use App\Entity\Users\UseCase\CreateUser;
use App\Entity\Users\UseCase\CreateUser\Responder;
use App\Form\Users\AddType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param CreateUser $createUser
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/registration", name="registration", methods={"GET", "POST"})
     */
    public function index(Request $request, CreateUser $createUser)
    {
        $form = $this->createForm(AddType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new CreateUser\Command(
                (string)$data['login'],
                (string)$data['password'],
                (string)$data['name'],
                (string)$data['surname'],
                (int)$data['age'],
                (string)$data['email']
            );
            $command->setResponder($this);

            $createUser->execute($command);

            return $this->redirectToRoute('login');
        }

        return $this->render('users/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function userCreated()
    {
        $this->addFlash('success', 'Konto stworzone. Został wysłany mail do potwierdzenia');
    }

    public function userExisted()
    {
        $this->addFlash('error', 'Login już istnieje');
    }
}