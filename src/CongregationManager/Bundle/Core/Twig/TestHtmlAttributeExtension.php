<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class TestHtmlAttributeExtension extends AbstractExtension
{
    public function __construct(
        private readonly string $env
    ) {
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('test_html_attribute', [$this, 'testHtmlAttribute'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    public function testHtmlAttribute(string $name, ?string $value = null): string
    {
        if (str_starts_with($this->env, 'test')) {
            return sprintf('data-test-%s="%s"', $name, (string) $value);
        }

        return '';
    }
}
