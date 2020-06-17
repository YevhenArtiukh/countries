<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 20:44
 */

namespace App\Controller\Languages;


use App\Entity\Languages\Language;
use App\Entity\Languages\UseCase\EditLanguage;
use App\Entity\Languages\UseCase\EditLanguage\Responder;
use App\Form\Languages\EditType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController implements Responder
{
    /**
     * @param Request $request
     * @param Language $language
     * @param EditLanguage $editLanguage
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     * @Route("/language/{language}/edit", name="language_edit", methods={"GET", "POST"})
     */
    public function index(Request $request, Language $language, EditLanguage $editLanguage)
    {
        $form = $this->createForm(
            EditType::class,
            [
                'name' => $language->getName()
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = new EditLanguage\Command(
                $language,
                (string)$data['name']
            );
            $command->setResponder($this);

            $editLanguage->execute($command);

            return $this->redirectToRoute('languages');
        }

        return $this->render('languages/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function languageEdited()
    {
        $this->addFlash('success', 'Język urzędowy został zmieniony');
    }
}