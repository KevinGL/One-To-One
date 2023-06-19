<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UsersRepository;

class UserController extends AbstractController
{
    #[Route("/users", name: "users")]
    public function index(UsersRepository $repo)
    {
        if(!$this->getUser())
        {
            return $this->redirectToRoute('app_login');
        }

        if(!$this->getUser()->getIsAdmin())
        {
            return $this->redirectToRoute('main');
        }

        $users = $repo->findAll();

        return $this->render("user/index.html.twig", ["users" => $users]);
    }
}