<?php


namespace CongregationManager\Infrastructure\Common\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AppDashboardController extends AbstractController
{
    public function index(Request $request): Response
    {
        return $this->render('app/dashboard/index.html.twig');
    }
}
