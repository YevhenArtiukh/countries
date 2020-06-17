<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 20:44
 */

namespace App\Controller\Languages;


use App\Adapter\Languages\ReadModel\LanguageQuery;
use App\Entity\Users\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @param LanguageQuery $languageQuery
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/languages", name="languages", methods={"GET"})
     */
    public function index(LanguageQuery $languageQuery)
    {
        if (!$this->isGranted(User::ROLE_ADMIN))
            throw $this->createAccessDeniedException();

        return $this->render('languages/list.html.twig', [
            'languages' => $languageQuery->findAll()
        ]);
    }
}