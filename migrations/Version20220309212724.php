<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309212724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add App User Invitation table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_user_invitation (brother_id INT NOT NULL, email VARCHAR(255) NOT NULL, token VARCHAR(100) NOT NULL, PRIMARY KEY(brother_id))');
        $this->addSql('CREATE INDEX IDX_CA082C75F37A13B ON app_user_invitation (token)');
        $this->addSql('ALTER TABLE app_user_invitation ADD CONSTRAINT FK_CA082C714621078 FOREIGN KEY (brother_id) REFERENCES brother (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE app_user_invitation');
    }
}
