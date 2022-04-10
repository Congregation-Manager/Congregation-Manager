<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220410135108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add municipality table.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE municipality_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE municipality (id INT NOT NULL, congregation_id INT NOT NULL, province_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C6F566282D82FAA1 ON municipality (congregation_id)');
        $this->addSql('CREATE INDEX IDX_C6F56628E946114A ON municipality (province_id)');
        $this->addSql('ALTER TABLE municipality ADD CONSTRAINT FK_C6F566282D82FAA1 FOREIGN KEY (congregation_id) REFERENCES congregation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE municipality ADD CONSTRAINT FK_C6F56628E946114A FOREIGN KEY (province_id) REFERENCES province (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE municipality_id_seq CASCADE');
        $this->addSql('DROP TABLE municipality');
    }
}
