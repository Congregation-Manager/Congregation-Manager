<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220906171809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change territory name to number.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE territory ADD number INT NOT NULL');
        $this->addSql('ALTER TABLE territory DROP name');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E974396696901F542D82FAA1 ON territory (number, congregation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_E974396696901F542D82FAA1');
        $this->addSql('ALTER TABLE territory ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE territory DROP number');
    }
}
