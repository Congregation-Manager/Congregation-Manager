<?php


namespace App\Infrastructure\Common\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HomePageController extends AbstractController
{
    public function index(Request $request): Response
    {
        return $this->render('app/homepage/index.html.twig');
    }
}
