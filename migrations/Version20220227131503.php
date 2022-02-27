<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220227131503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Brother table.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE brother_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE brother (id INT NOT NULL, congregation_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, middle_name VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, baptism_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D8D5EC452D82FAA1 ON brother (congregation_id)');
        $this->addSql('ALTER TABLE brother ADD CONSTRAINT FK_D8D5EC452D82FAA1 FOREIGN KEY (congregation_id) REFERENCES congregation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE app_user ADD brother_id INT NOT NULL');
        $this->addSql('ALTER TABLE app_user ADD CONSTRAINT FK_88BDF3E914621078 FOREIGN KEY (brother_id) REFERENCES brother (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E914621078 ON app_user (brother_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE app_user DROP CONSTRAINT FK_88BDF3E914621078');
        $this->addSql('DROP SEQUENCE brother_id_seq CASCADE');
        $this->addSql('DROP TABLE brother');
        $this->addSql('DROP INDEX UNIQ_88BDF3E914621078');
        $this->addSql('ALTER TABLE app_user DROP brother_id');
    }
}
