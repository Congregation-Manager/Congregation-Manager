<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Admin\Controller;

use CongregationManager\Bundle\User\Entity\UserInterface;
use CongregationManager\Component\Core\Domain\Context\ThemeContextInterface;
use CongregationManager\Component\Core\Domain\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

final class ThemeController extends AbstractController
{
    public function __construct(
        private readonly ThemeContextInterface $themeContext,
        private readonly RequestStack $requestStack,
        private readonly Security $security,
    ) {
    }

    public function renderAction(): Response
    {
        return $this->render('@CongregationManagerAdmin/components/theme/_switch_theme.html.twig', [
            'active' => $this->themeContext->getTheme(),
            'themes' => Theme::cases(),
        ]);
    }

    public function switchTheme(Request $request, ?string $theme = null): Response
    {
        if ($theme !== null) {
            $theme = Theme::tryFrom($theme);
            if ($theme === null) {
                throw $this->createNotFoundException();
            }
        }
        $user = $this->security->getUser();
        if ($user instanceof UserInterface) {
            //@TODO: Implement this
            //$user->setTheme($theme);
            //$this->entityManager->flush();
        }
        $session = $this->requestStack->getSession();
        if ($theme === null) {
            $session->remove('_theme');
        } else {
            $session->set('_theme', $theme->value);
        }
        $referer = $request->headers->get('referer');
        if ($referer !== null) {
            return $this->redirect($referer);
        }

        return $this->redirectToRoute('congregation_manager_admin_dashboard');
    }
}
