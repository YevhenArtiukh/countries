<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 17:57
 */

namespace App\Controller\Countries;


use App\Entity\Countries\Country;
use App\Entity\Countries\UseCase\EditCountry;
use App\Entity\Countries\UseCase\EditCountry\Responder;
use App\Entity\Users\User;
use App\Form\Countries\EditType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param Country $country
     * @param EditCountry $editCountry
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/country/{country}/edit", name="country_edit", methods={"GET", "POST"})
     */
    public function index(Request $request, Country $country, EditCountry $editCountry)
    {
        if(!$this->isGranted(User::ROLE_ADMIN))
            throw $this->createAccessDeniedException();

        $form = $this->createForm(
            EditType::class,
            [
                'name' => $country->getName(),
                'languages' => $country->getLanguages()->toArray()
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new EditCountry\Command(
                $country,
                (string)$data['name'],
                $data['flag'],
                (array)$data['languages']
            );
            $command->setResponder($this);

            $editCountry->execute($command);

            return $this->redirectToRoute('countries');
        }

        return $this->render('countries/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function countryEdited()
    {
        $this->addFlash('success', 'Kraj został zmieniony');
    }
}