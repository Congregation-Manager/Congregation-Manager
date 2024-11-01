<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class TestFormAttributeExtension extends AbstractExtension
{
    public function __construct(
        private readonly string $env
    ) {
    }

    /**
     * @return TwigFunction[]
     */
    #[\Override]
    public function getFunctions(): array
    {
        return [
            new TwigFunction('test_form_attribute', $this->testFormAttribute(...), [
                'is_safe' => ['html'],
            ]),
        ];
    }

    /**
     * @phpstan-ignore-next-line
     */
    public function testFormAttribute(string $name, ?string $value = null): array
    {
        if (str_starts_with($this->env, 'test')) {
            return [
                'attr' => [
                    'data-test-' . $name => (string) $value,
                ],
            ];
        }

        return [];
    }
}
