<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 13:09
 */

namespace App\Controller\Users;


use App\Adapter\Users\ReadModel\UserQuery;
use App\Entity\Users\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @param UserQuery $userQuery
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("users", name="users", methods={"GET"})
     */
    public function index(UserQuery $userQuery)
    {
        if(!$this->isGranted(User::ROLE_USER) && !$this->isGranted(User::ROLE_ADMIN))
            throw $this->createAccessDeniedException();

        return $this->render('users/list.html.twig', [
            'users' => $userQuery->findAll()
        ]);
    }
}