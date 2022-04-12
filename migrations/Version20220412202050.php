<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412202050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add territory assignment table.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE territory_assignment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE territory_assignment (id INT NOT NULL, territory_id INT NOT NULL, brother_id INT DEFAULT NULL, assignment_date DATE NOT NULL, revocation_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4ED9EDD873F74AD4 ON territory_assignment (territory_id)');
        $this->addSql('CREATE INDEX IDX_4ED9EDD814621078 ON territory_assignment (brother_id)');
        $this->addSql('ALTER TABLE territory_assignment ADD CONSTRAINT FK_4ED9EDD873F74AD4 FOREIGN KEY (territory_id) REFERENCES territory (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE territory_assignment ADD CONSTRAINT FK_4ED9EDD814621078 FOREIGN KEY (brother_id) REFERENCES brother (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE territory_assignment_id_seq CASCADE');
        $this->addSql('DROP TABLE territory_assignment');
    }
}
