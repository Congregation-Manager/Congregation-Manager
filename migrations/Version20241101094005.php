<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241101094005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin_user (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, locale_code VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AD8A54A9E7927C74 ON admin_user (email)');
        $this->addSql('CREATE TABLE app_user (id SERIAL NOT NULL, brother_id INT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, locale_code VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9E7927C74 ON app_user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E914621078 ON app_user (brother_id)');
        $this->addSql('CREATE TABLE app_user_invitation (brother_id INT NOT NULL, email VARCHAR(255) NOT NULL, token VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(brother_id))');
        $this->addSql('CREATE INDEX IDX_CA082C75F37A13B ON app_user_invitation (token)');
        $this->addSql('COMMENT ON COLUMN app_user_invitation.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE area (id SERIAL NOT NULL, congregation_id INT NOT NULL, municipality_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D7943D682D82FAA1 ON area (congregation_id)');
        $this->addSql('CREATE INDEX IDX_D7943D68AE6F181C ON area (municipality_id)');
        $this->addSql('CREATE TABLE brother (id SERIAL NOT NULL, congregation_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, middle_name VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, baptism_date DATE DEFAULT NULL, male BOOLEAN DEFAULT true NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D8D5EC452D82FAA1 ON brother (congregation_id)');
        $this->addSql('CREATE TABLE congregation (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE municipality (id SERIAL NOT NULL, congregation_id INT NOT NULL, province_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C6F566282D82FAA1 ON municipality (congregation_id)');
        $this->addSql('CREATE INDEX IDX_C6F56628E946114A ON municipality (province_id)');
        $this->addSql('CREATE TABLE province (id SERIAL NOT NULL, congregation_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4ADAD40B2D82FAA1 ON province (congregation_id)');
        $this->addSql('CREATE TABLE reset_password_request (id SERIAL NOT NULL, app_user_id INT DEFAULT NULL, admin_user_id INT DEFAULT NULL, hashed_token VARCHAR(100) NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, selector VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CE748A4A3353D8 ON reset_password_request (app_user_id)');
        $this->addSql('CREATE INDEX IDX_7CE748A6352511C ON reset_password_request (admin_user_id)');
        $this->addSql('COMMENT ON COLUMN reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE territory (id SERIAL NOT NULL, congregation_id INT NOT NULL, area_id INT NOT NULL, number INT NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E97439662D82FAA1 ON territory (congregation_id)');
        $this->addSql('CREATE INDEX IDX_E9743966BD0F409C ON territory (area_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E974396696901F542D82FAA1 ON territory (number, congregation_id)');
        $this->addSql('CREATE TABLE territory_assignment (id SERIAL NOT NULL, territory_id INT NOT NULL, brother_id INT DEFAULT NULL, assignment_date DATE NOT NULL, revocation_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4ED9EDD873F74AD4 ON territory_assignment (territory_id)');
        $this->addSql('CREATE INDEX IDX_4ED9EDD814621078 ON territory_assignment (brother_id)');
        $this->addSql('ALTER TABLE app_user ADD CONSTRAINT FK_88BDF3E914621078 FOREIGN KEY (brother_id) REFERENCES brother (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE app_user_invitation ADD CONSTRAINT FK_CA082C714621078 FOREIGN KEY (brother_id) REFERENCES brother (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE area ADD CONSTRAINT FK_D7943D682D82FAA1 FOREIGN KEY (congregation_id) REFERENCES congregation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE area ADD CONSTRAINT FK_D7943D68AE6F181C FOREIGN KEY (municipality_id) REFERENCES municipality (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE brother ADD CONSTRAINT FK_D8D5EC452D82FAA1 FOREIGN KEY (congregation_id) REFERENCES congregation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE municipality ADD CONSTRAINT FK_C6F566282D82FAA1 FOREIGN KEY (congregation_id) REFERENCES congregation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE municipality ADD CONSTRAINT FK_C6F56628E946114A FOREIGN KEY (province_id) REFERENCES province (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE province ADD CONSTRAINT FK_4ADAD40B2D82FAA1 FOREIGN KEY (congregation_id) REFERENCES congregation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748A4A3353D8 FOREIGN KEY (app_user_id) REFERENCES app_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748A6352511C FOREIGN KEY (admin_user_id) REFERENCES admin_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE territory ADD CONSTRAINT FK_E97439662D82FAA1 FOREIGN KEY (congregation_id) REFERENCES congregation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE territory ADD CONSTRAINT FK_E9743966BD0F409C FOREIGN KEY (area_id) REFERENCES area (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE territory_assignment ADD CONSTRAINT FK_4ED9EDD873F74AD4 FOREIGN KEY (territory_id) REFERENCES territory (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE territory_assignment ADD CONSTRAINT FK_4ED9EDD814621078 FOREIGN KEY (brother_id) REFERENCES brother (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE app_user DROP CONSTRAINT FK_88BDF3E914621078');
        $this->addSql('ALTER TABLE app_user_invitation DROP CONSTRAINT FK_CA082C714621078');
        $this->addSql('ALTER TABLE area DROP CONSTRAINT FK_D7943D682D82FAA1');
        $this->addSql('ALTER TABLE area DROP CONSTRAINT FK_D7943D68AE6F181C');
        $this->addSql('ALTER TABLE brother DROP CONSTRAINT FK_D8D5EC452D82FAA1');
        $this->addSql('ALTER TABLE municipality DROP CONSTRAINT FK_C6F566282D82FAA1');
        $this->addSql('ALTER TABLE municipality DROP CONSTRAINT FK_C6F56628E946114A');
        $this->addSql('ALTER TABLE province DROP CONSTRAINT FK_4ADAD40B2D82FAA1');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT FK_7CE748A4A3353D8');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT FK_7CE748A6352511C');
        $this->addSql('ALTER TABLE territory DROP CONSTRAINT FK_E97439662D82FAA1');
        $this->addSql('ALTER TABLE territory DROP CONSTRAINT FK_E9743966BD0F409C');
        $this->addSql('ALTER TABLE territory_assignment DROP CONSTRAINT FK_4ED9EDD873F74AD4');
        $this->addSql('ALTER TABLE territory_assignment DROP CONSTRAINT FK_4ED9EDD814621078');
        $this->addSql('DROP TABLE admin_user');
        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP TABLE app_user_invitation');
        $this->addSql('DROP TABLE area');
        $this->addSql('DROP TABLE brother');
        $this->addSql('DROP TABLE congregation');
        $this->addSql('DROP TABLE municipality');
        $this->addSql('DROP TABLE province');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE territory');
        $this->addSql('DROP TABLE territory_assignment');
    }
}
