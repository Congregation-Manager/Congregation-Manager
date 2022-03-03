<?php

namespace CongregationManager\Tests\Integration\Infrastructure\User\Command;

use CongregationManager\Tests\Integration\Infrastructure\Common\Command\AbstractCommandTest;
use InvalidArgumentException;

final class CreateAdminUserCommandTest extends AbstractCommandTest
{
    public function testCreateAdminUserInteractive(): void
    {
        $this->executeCommand(
            [], [
            'admin@cm.org',
            'password',
            'en',
        ]);

        $adminUsers = self::getContainer()->get('cm.repository.admin_user')->findAll();
        $this->assertCount(1, $adminUsers);

        $adminUser = $adminUsers[0];
        $this->assertEquals('admin@cm.org', $adminUser->getEmail());
        $this->assertEquals('en', $adminUser->getLocaleCode());
        $this->assertTrue(self::getContainer()->get('security.user_password_hasher')->isPasswordValid($adminUser, 'password'));
    }

    public function testCreateAdminUserDefaultLocale(): void
    {
        $this->executeCommand(
            [], [
            'admin@cm.org',
            'password',
            null
        ]);

        $adminUsers = self::getContainer()->get('cm.repository.admin_user')->findAll();
        $this->assertCount(1, $adminUsers);

        $adminUser = $adminUsers[0];
        $this->assertEquals('admin@cm.org', $adminUser->getEmail());
        $this->assertEquals('en', $adminUser->getLocaleCode());
        $this->assertTrue(self::getContainer()->get('security.user_password_hasher')->isPasswordValid($adminUser, 'password'));
    }

    public function test_it_does_not_create_admin_user_if_locale_is_not_valid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->executeCommand(
            [], [
            'admin@cm.org',
            'password',
            'ge'
        ]);
    }

    protected function getCommandServiceDefinition(): string
    {
        return 'cm.command.create_admin_user';
    }
}
