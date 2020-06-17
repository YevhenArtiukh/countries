<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 14:29
 */

namespace App\Controller\Users;


use App\Entity\Users\UseCase\AddCountriesUser;
use App\Entity\Users\UseCase\AddCountriesUser\Responder;
use App\Form\Users\AddCountriesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddCountriesController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param AddCountriesUser $addCountriesUser
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/user/countries", name="user_add_countries", methods={"GET", "POST"})
     */
    public function index(Request $request, AddCountriesUser $addCountriesUser)
    {
        $form = $this->createForm(
            AddCountriesType::class,
            [
                'countries' => $this->getUser()->getCountries()
            ]
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new AddCountriesUser\Command(
                $this->getUser(),
                $data['countries']
            );
            $command->setResponder($this);

            $addCountriesUser->execute($command);

            return $this->redirectToRoute('countries');
        }

        return $this->render('users/add_countries.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function userCountriesEdited()
    {
        $this->addFlash('success', 'Zmiany zostały zapisane');
    }
}
