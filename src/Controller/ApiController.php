<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Security;


class ApiController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;


    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/api/me", name="api_me")
     */
    public function me()
    {
        $user = $this->security->getUser();
        return $user;
    }
}
