<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AdminDashboardController extends AbstractController
{
    public function index(Request $request): Response
    {
        return $this->render('admin/dashboard/index.html.twig');
    }
}
