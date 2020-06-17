<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 17:29
 */

namespace App\Controller\Countries;


use App\Entity\Countries\Country;
use App\Entity\Countries\UseCase\AcceptCountry;
use App\Entity\Countries\UseCase\AcceptCountry\Responder;
use App\Entity\Users\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AcceptController extends AbstractController implements Responder
{
    /**
     * @param Country $country
     * @param AcceptCountry $acceptCountry
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Throwable
     * @Route("/country/{country}/accept", name="country_accept", methods={"GET"})
     */
    public function index(Country $country, AcceptCountry $acceptCountry)
    {
        if (!$this->isGranted(User::ROLE_ADMIN))
            throw $this->createAccessDeniedException();

        $command = new AcceptCountry\Command(
            $country
        );
        $command->setResponder($this);

        $acceptCountry->execute($command);

        return $this->redirectToRoute('countries');
    }

    public function countryAccepted()
    {
        $this->addFlash('success', 'Kraj został zaakceptowany');
    }
}