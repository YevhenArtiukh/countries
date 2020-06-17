<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 17:38
 */

namespace App\Controller\Countries;


use App\Entity\Countries\Country;
use App\Entity\Countries\UseCase\DeleteCountry;
use App\Entity\Countries\UseCase\DeleteCountry\Responder;
use App\Entity\Users\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param Country $country
     * @param DeleteCountry $deleteCountry
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Throwable
     * @Route("/country/{country}/delete", name="country_delete", methods={"DELETE"})
     */
    public function index(Request $request, Country $country, DeleteCountry $deleteCountry)
    {
        if ($this->isCsrfTokenValid('delete' . (int)$country->getId(), $request->request->get('_token')) and $this->isGranted(User::ROLE_ADMIN)) {

            $command = new DeleteCountry\Command(
                $country
            );
            $command->setResponder($this);

            $deleteCountry->execute($command);
        }

        return $this->redirectToRoute('countries');
    }

    public function countryDeleted()
    {
        $this->addFlash('success', 'Kraj został usunięty');
    }
}