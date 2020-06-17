<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 14:55
 */

namespace App\Controller\Users;


use App\Entity\Users\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Routing\Annotation\Route;

class GeneratePdfController extends AbstractController
{
    /**
     * @Route("/user/{user}/generate-pdf", name="user_generate_pdf", methods={"GET"})
     */
    public function index(User $user)
    {
        if(!$this->isGranted(User::ROLE_USER) && !$this->isGranted(User::ROLE_ADMIN))
            throw $this->createAccessDeniedException();

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);

        $html = $this->renderView('users/generate_pdf.html.twig', [
            'user' => $user
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream($user->getSurname().' '.$user->getName().".pdf", [
            "Attachment" => true
        ]);
    }
}