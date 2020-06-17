<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 13:18
 */

namespace App\Controller\Users;


use App\Adapter\Users\ReadModel\UserQuery;
use App\Entity\Users\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    /**
     * @param User $user
     * @param UserQuery $userQuery
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/user/{user}", name="user_show", methods={"GET"})
     */
    public function index(User $user, UserQuery $userQuery)
    {
        if(!$this->isGranted(User::ROLE_USER) && !$this->isGranted(User::ROLE_ADMIN))
            throw $this->createAccessDeniedException();

        return $this->render('users/show.html.twig', [
            'user' => $userQuery->findOneById($user->getId())
        ]);
    }
}