<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 13:34
 */

namespace App\Controller\Countries;


use App\Entity\Countries\UseCase\CreateCountry;
use App\Entity\Countries\UseCase\CreateCountry\Responder;
use App\Entity\Users\User;
use App\Form\Countries\AddType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param CreateCountry $createCountry
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/country/add", name="country_add", methods={"GET", "POST"})
     */
    public function index(Request $request, CreateCountry $createCountry)
    {
        if (!$this->isGranted(User::ROLE_USER) && !$this->isGranted(User::ROLE_ADMIN))
            throw $this->createAccessDeniedException();

        $roles = $this->getUser()->getRoles();

        $form = $this->createForm(
            AddType::class,
            [],
            [
                'role' => reset($roles)
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new CreateCountry\Command(
                (string)$data['name'],
                $data['flag'],
                (array)$data['languages'],
                array_key_exists('users', $data) ? $data['users'] : new ArrayCollection()
            );
            $command->setResponder($this);

            $createCountry->execute($command);

            return $this->redirectToRoute('countries');
        }

        return $this->render('countries/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function countryCreated()
    {
        $this->addFlash('success', 'Kraj został dodany');
    }

    public function countryExisted()
    {
        $this->addFlash('error', 'Kraj już istnieje');
    }
}