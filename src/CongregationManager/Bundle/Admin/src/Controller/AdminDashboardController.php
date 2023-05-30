<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Admin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AdminDashboardController extends AbstractController
{
    public function index(Request $request): Response
    {
        return $this->render('@CongregationManagerAdmin/dashboard/index.html.twig');
    }
}
