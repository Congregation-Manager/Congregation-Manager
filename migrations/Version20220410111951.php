<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220410111951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add on delete operation on foreign keys.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_user DROP CONSTRAINT FK_88BDF3E914621078');
        $this->addSql('ALTER TABLE app_user ADD CONSTRAINT FK_88BDF3E914621078 FOREIGN KEY (brother_id) REFERENCES brother (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE app_user_invitation DROP CONSTRAINT FK_CA082C714621078');
        $this->addSql('ALTER TABLE app_user_invitation ADD CONSTRAINT FK_CA082C714621078 FOREIGN KEY (brother_id) REFERENCES brother (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE brother DROP CONSTRAINT FK_D8D5EC452D82FAA1');
        $this->addSql('ALTER TABLE brother ADD CONSTRAINT FK_D8D5EC452D82FAA1 FOREIGN KEY (congregation_id) REFERENCES congregation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT FK_7CE748A4A3353D8');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT FK_7CE748A6352511C');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748A4A3353D8 FOREIGN KEY (app_user_id) REFERENCES app_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748A6352511C FOREIGN KEY (admin_user_id) REFERENCES admin_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE app_user_invitation DROP CONSTRAINT fk_ca082c714621078');
        $this->addSql('ALTER TABLE app_user_invitation ADD CONSTRAINT fk_ca082c714621078 FOREIGN KEY (brother_id) REFERENCES brother (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE brother DROP CONSTRAINT fk_d8d5ec452d82faa1');
        $this->addSql('ALTER TABLE brother ADD CONSTRAINT fk_d8d5ec452d82faa1 FOREIGN KEY (congregation_id) REFERENCES congregation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE app_user DROP CONSTRAINT fk_88bdf3e914621078');
        $this->addSql('ALTER TABLE app_user ADD CONSTRAINT fk_88bdf3e914621078 FOREIGN KEY (brother_id) REFERENCES brother (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT fk_7ce748a4a3353d8');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT fk_7ce748a6352511c');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT fk_7ce748a4a3353d8 FOREIGN KEY (app_user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT fk_7ce748a6352511c FOREIGN KEY (admin_user_id) REFERENCES admin_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
