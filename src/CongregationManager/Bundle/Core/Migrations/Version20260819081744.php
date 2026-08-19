<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260819081744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin_reset_password_request (id UUID NOT NULL, user_id UUID DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, hashed_token VARCHAR(100) NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, selector VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_93470FAAA76ED395 ON admin_reset_password_request (user_id)');
        $this->addSql('COMMENT ON COLUMN admin_reset_password_request.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_reset_password_request.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE admin_user (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, locale_code VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AD8A54A9E7927C74 ON admin_user (email)');
        $this->addSql('COMMENT ON COLUMN admin_user.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_user.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE app_reset_password_request (id UUID NOT NULL, user_id UUID DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, hashed_token VARCHAR(100) NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, selector VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2AD4C710A76ED395 ON app_reset_password_request (user_id)');
        $this->addSql('COMMENT ON COLUMN app_reset_password_request.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN app_reset_password_request.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN app_reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN app_reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE app_user (id UUID NOT NULL, brother_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, locale_code VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9E7927C74 ON app_user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E914621078 ON app_user (brother_id)');
        $this->addSql('COMMENT ON COLUMN app_user.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN app_user.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE app_user_invitation (brother_id UUID NOT NULL, email VARCHAR(255) NOT NULL, token VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(brother_id))');
        $this->addSql('CREATE INDEX IDX_CA082C75F37A13B ON app_user_invitation (token)');
        $this->addSql('COMMENT ON COLUMN app_user_invitation.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE area (id UUID NOT NULL, congregation_id UUID NOT NULL, municipality_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D7943D682D82FAA1 ON area (congregation_id)');
        $this->addSql('CREATE INDEX IDX_D7943D68AE6F181C ON area (municipality_id)');
        $this->addSql('COMMENT ON COLUMN area.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN area.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE brother (id UUID NOT NULL, congregation_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, middle_name VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, baptism_date DATE DEFAULT NULL, male BOOLEAN DEFAULT true NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D8D5EC452D82FAA1 ON brother (congregation_id)');
        $this->addSql('COMMENT ON COLUMN brother.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN brother.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE congregation (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN congregation.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN congregation.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE municipality (id UUID NOT NULL, congregation_id UUID NOT NULL, province_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C6F566282D82FAA1 ON municipality (congregation_id)');
        $this->addSql('CREATE INDEX IDX_C6F56628E946114A ON municipality (province_id)');
        $this->addSql('COMMENT ON COLUMN municipality.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN municipality.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE province (id UUID NOT NULL, congregation_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4ADAD40B2D82FAA1 ON province (congregation_id)');
        $this->addSql('COMMENT ON COLUMN province.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN province.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE territory (id UUID NOT NULL, congregation_id UUID NOT NULL, area_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, number INT NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E97439662D82FAA1 ON territory (congregation_id)');
        $this->addSql('CREATE INDEX IDX_E9743966BD0F409C ON territory (area_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E974396696901F542D82FAA1 ON territory (number, congregation_id)');
        $this->addSql('COMMENT ON COLUMN territory.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN territory.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE territory_assignment (id UUID NOT NULL, territory_id UUID NOT NULL, recipient_id UUID DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, assignment_date DATE NOT NULL, revocation_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4ED9EDD873F74AD4 ON territory_assignment (territory_id)');
        $this->addSql('CREATE INDEX IDX_4ED9EDD8E92F8F78 ON territory_assignment (recipient_id)');
        $this->addSql('COMMENT ON COLUMN territory_assignment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN territory_assignment.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE admin_reset_password_request ADD CONSTRAINT FK_93470FAAA76ED395 FOREIGN KEY (user_id) REFERENCES admin_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE app_reset_password_request ADD CONSTRAINT FK_2AD4C710A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE app_user ADD CONSTRAINT FK_88BDF3E914621078 FOREIGN KEY (brother_id) REFERENCES brother (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE app_user_invitation ADD CONSTRAINT FK_CA082C714621078 FOREIGN KEY (brother_id) REFERENCES brother (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE area ADD CONSTRAINT FK_D7943D682D82FAA1 FOREIGN KEY (congregation_id) REFERENCES congregation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE area ADD CONSTRAINT FK_D7943D68AE6F181C FOREIGN KEY (municipality_id) REFERENCES municipality (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE brother ADD CONSTRAINT FK_D8D5EC452D82FAA1 FOREIGN KEY (congregation_id) REFERENCES congregation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE municipality ADD CONSTRAINT FK_C6F566282D82FAA1 FOREIGN KEY (congregation_id) REFERENCES congregation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE municipality ADD CONSTRAINT FK_C6F56628E946114A FOREIGN KEY (province_id) REFERENCES province (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE province ADD CONSTRAINT FK_4ADAD40B2D82FAA1 FOREIGN KEY (congregation_id) REFERENCES congregation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE territory ADD CONSTRAINT FK_E97439662D82FAA1 FOREIGN KEY (congregation_id) REFERENCES congregation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE territory ADD CONSTRAINT FK_E9743966BD0F409C FOREIGN KEY (area_id) REFERENCES area (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE territory_assignment ADD CONSTRAINT FK_4ED9EDD873F74AD4 FOREIGN KEY (territory_id) REFERENCES territory (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE territory_assignment ADD CONSTRAINT FK_4ED9EDD8E92F8F78 FOREIGN KEY (recipient_id) REFERENCES brother (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE admin_reset_password_request DROP CONSTRAINT FK_93470FAAA76ED395');
        $this->addSql('ALTER TABLE app_reset_password_request DROP CONSTRAINT FK_2AD4C710A76ED395');
        $this->addSql('ALTER TABLE app_user DROP CONSTRAINT FK_88BDF3E914621078');
        $this->addSql('ALTER TABLE app_user_invitation DROP CONSTRAINT FK_CA082C714621078');
        $this->addSql('ALTER TABLE area DROP CONSTRAINT FK_D7943D682D82FAA1');
        $this->addSql('ALTER TABLE area DROP CONSTRAINT FK_D7943D68AE6F181C');
        $this->addSql('ALTER TABLE brother DROP CONSTRAINT FK_D8D5EC452D82FAA1');
        $this->addSql('ALTER TABLE municipality DROP CONSTRAINT FK_C6F566282D82FAA1');
        $this->addSql('ALTER TABLE municipality DROP CONSTRAINT FK_C6F56628E946114A');
        $this->addSql('ALTER TABLE province DROP CONSTRAINT FK_4ADAD40B2D82FAA1');
        $this->addSql('ALTER TABLE territory DROP CONSTRAINT FK_E97439662D82FAA1');
        $this->addSql('ALTER TABLE territory DROP CONSTRAINT FK_E9743966BD0F409C');
        $this->addSql('ALTER TABLE territory_assignment DROP CONSTRAINT FK_4ED9EDD873F74AD4');
        $this->addSql('ALTER TABLE territory_assignment DROP CONSTRAINT FK_4ED9EDD8E92F8F78');
        $this->addSql('DROP TABLE admin_reset_password_request');
        $this->addSql('DROP TABLE admin_user');
        $this->addSql('DROP TABLE app_reset_password_request');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP TABLE app_user_invitation');
        $this->addSql('DROP TABLE area');
        $this->addSql('DROP TABLE brother');
        $this->addSql('DROP TABLE congregation');
        $this->addSql('DROP TABLE municipality');
        $this->addSql('DROP TABLE province');
        $this->addSql('DROP TABLE territory');
        $this->addSql('DROP TABLE territory_assignment');
    }
}
