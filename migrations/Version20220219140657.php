<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220219140657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add locale code to app and admin user.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_user ADD locale_code VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE app_user ADD locale_code VARCHAR(10) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE app_user DROP locale_code');
        $this->addSql('ALTER TABLE admin_user DROP locale_code');
    }
}
