<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241129155853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE reset_password_request_id_seq CASCADE');
        $this->addSql('CREATE TABLE admin_reset_password_request (id SERIAL NOT NULL, user_id INT DEFAULT NULL, hashed_token VARCHAR(100) NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, selector VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_93470FAAA76ED395 ON admin_reset_password_request (user_id)');
        $this->addSql('COMMENT ON COLUMN admin_reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN admin_reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE app_reset_password_request (id SERIAL NOT NULL, user_id INT DEFAULT NULL, hashed_token VARCHAR(100) NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, selector VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2AD4C710A76ED395 ON app_reset_password_request (user_id)');
        $this->addSql('COMMENT ON COLUMN app_reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN app_reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE admin_reset_password_request ADD CONSTRAINT FK_93470FAAA76ED395 FOREIGN KEY (user_id) REFERENCES admin_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE app_reset_password_request ADD CONSTRAINT FK_2AD4C710A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT fk_7ce748a4a3353d8');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT fk_7ce748a6352511c');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE territory_assignment DROP CONSTRAINT fk_4ed9edd814621078');
        $this->addSql('DROP INDEX idx_4ed9edd814621078');
        $this->addSql('ALTER TABLE territory_assignment RENAME COLUMN brother_id TO recipient_id');
        $this->addSql('ALTER TABLE territory_assignment ADD CONSTRAINT FK_4ED9EDD8E92F8F78 FOREIGN KEY (recipient_id) REFERENCES brother (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4ED9EDD8E92F8F78 ON territory_assignment (recipient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE reset_password_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE reset_password_request (id SERIAL NOT NULL, app_user_id INT DEFAULT NULL, admin_user_id INT DEFAULT NULL, hashed_token VARCHAR(100) NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, selector VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_7ce748a6352511c ON reset_password_request (admin_user_id)');
        $this->addSql('CREATE INDEX idx_7ce748a4a3353d8 ON reset_password_request (app_user_id)');
        $this->addSql('COMMENT ON COLUMN reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT fk_7ce748a4a3353d8 FOREIGN KEY (app_user_id) REFERENCES app_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT fk_7ce748a6352511c FOREIGN KEY (admin_user_id) REFERENCES admin_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin_reset_password_request DROP CONSTRAINT FK_93470FAAA76ED395');
        $this->addSql('ALTER TABLE app_reset_password_request DROP CONSTRAINT FK_2AD4C710A76ED395');
        $this->addSql('DROP TABLE admin_reset_password_request');
        $this->addSql('DROP TABLE app_reset_password_request');
        $this->addSql('ALTER TABLE territory_assignment DROP CONSTRAINT FK_4ED9EDD8E92F8F78');
        $this->addSql('DROP INDEX IDX_4ED9EDD8E92F8F78');
        $this->addSql('ALTER TABLE territory_assignment RENAME COLUMN recipient_id TO brother_id');
        $this->addSql('ALTER TABLE territory_assignment ADD CONSTRAINT fk_4ed9edd814621078 FOREIGN KEY (brother_id) REFERENCES brother (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_4ed9edd814621078 ON territory_assignment (brother_id)');
    }
}
