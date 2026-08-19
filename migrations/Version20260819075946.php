<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260819075946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_reset_password_request ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE admin_reset_password_request ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN admin_reset_password_request.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_reset_password_request.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE admin_user ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE admin_user ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN admin_user.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_user.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE app_reset_password_request ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE app_reset_password_request ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN app_reset_password_request.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN app_reset_password_request.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE app_user ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE app_user ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN app_user.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN app_user.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE area ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE area ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN area.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN area.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE brother ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE brother ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN brother.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN brother.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE congregation ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE congregation ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN congregation.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN congregation.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE municipality ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE municipality ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN municipality.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN municipality.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE province ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE province ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN province.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN province.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE territory ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE territory ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN territory.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN territory.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE territory_assignment ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE territory_assignment ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN territory_assignment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN territory_assignment.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE admin_reset_password_request DROP created_at');
        $this->addSql('ALTER TABLE admin_reset_password_request DROP updated_at');
        $this->addSql('ALTER TABLE area DROP created_at');
        $this->addSql('ALTER TABLE area DROP updated_at');
        $this->addSql('ALTER TABLE congregation DROP created_at');
        $this->addSql('ALTER TABLE congregation DROP updated_at');
        $this->addSql('ALTER TABLE province DROP created_at');
        $this->addSql('ALTER TABLE province DROP updated_at');
        $this->addSql('ALTER TABLE municipality DROP created_at');
        $this->addSql('ALTER TABLE municipality DROP updated_at');
        $this->addSql('ALTER TABLE brother DROP created_at');
        $this->addSql('ALTER TABLE brother DROP updated_at');
        $this->addSql('ALTER TABLE admin_user DROP created_at');
        $this->addSql('ALTER TABLE admin_user DROP updated_at');
        $this->addSql('ALTER TABLE territory_assignment DROP created_at');
        $this->addSql('ALTER TABLE territory_assignment DROP updated_at');
        $this->addSql('ALTER TABLE app_reset_password_request DROP created_at');
        $this->addSql('ALTER TABLE app_reset_password_request DROP updated_at');
        $this->addSql('ALTER TABLE app_user DROP created_at');
        $this->addSql('ALTER TABLE app_user DROP updated_at');
        $this->addSql('ALTER TABLE territory DROP created_at');
        $this->addSql('ALTER TABLE territory DROP updated_at');
    }
}
