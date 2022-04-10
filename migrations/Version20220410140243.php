<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220410140243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add area table.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE area_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE area (id INT NOT NULL, congregation_id INT NOT NULL, municipality_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D7943D682D82FAA1 ON area (congregation_id)');
        $this->addSql('CREATE INDEX IDX_D7943D68AE6F181C ON area (municipality_id)');
        $this->addSql('ALTER TABLE area ADD CONSTRAINT FK_D7943D682D82FAA1 FOREIGN KEY (congregation_id) REFERENCES congregation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE area ADD CONSTRAINT FK_D7943D68AE6F181C FOREIGN KEY (municipality_id) REFERENCES municipality (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE area_id_seq CASCADE');
        $this->addSql('DROP TABLE area');
    }
}
