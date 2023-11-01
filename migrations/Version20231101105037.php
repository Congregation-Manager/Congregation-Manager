<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231101105037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE app_user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE admin_user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reset_password_request_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE congregation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE brother_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE province_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE municipality_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE area_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE territory_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE territory_assignment_id_seq CASCADE');
        $this->addSql('ALTER TABLE admin_user ALTER id TYPE INT');
        $this->addSql('ALTER TABLE app_user ALTER id TYPE INT');
        $this->addSql('ALTER TABLE app_user ALTER brother_id TYPE INT');
        $this->addSql('ALTER TABLE app_user_invitation ALTER brother_id TYPE INT');
        $this->addSql('ALTER TABLE area ALTER id TYPE INT');
        $this->addSql('ALTER TABLE area ALTER congregation_id TYPE INT');
        $this->addSql('ALTER TABLE area ALTER municipality_id TYPE INT');
        $this->addSql('ALTER TABLE brother ALTER id TYPE INT');
        $this->addSql('ALTER TABLE brother ALTER congregation_id TYPE INT');
        $this->addSql('ALTER TABLE congregation ALTER id TYPE INT');
        $this->addSql('ALTER TABLE municipality ALTER id TYPE INT');
        $this->addSql('ALTER TABLE municipality ALTER congregation_id TYPE INT');
        $this->addSql('ALTER TABLE municipality ALTER province_id TYPE INT');
        $this->addSql('ALTER TABLE province ALTER id TYPE INT');
        $this->addSql('ALTER TABLE province ALTER congregation_id TYPE INT');
        $this->addSql('ALTER TABLE reset_password_request ALTER id TYPE INT');
        $this->addSql('ALTER TABLE reset_password_request ALTER app_user_id TYPE INT');
        $this->addSql('ALTER TABLE reset_password_request ALTER admin_user_id TYPE INT');
        $this->addSql('ALTER TABLE territory ALTER id TYPE INT');
        $this->addSql('ALTER TABLE territory ALTER congregation_id TYPE INT');
        $this->addSql('ALTER TABLE territory ALTER area_id TYPE INT');
        $this->addSql('ALTER TABLE territory_assignment ALTER id TYPE INT');
        $this->addSql('ALTER TABLE territory_assignment ALTER territory_id TYPE INT');
        $this->addSql('ALTER TABLE territory_assignment ALTER brother_id TYPE INT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE app_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE admin_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reset_password_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE congregation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE brother_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE province_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE municipality_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE area_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE territory_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE territory_assignment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE congregation ALTER id TYPE INT');
        $this->addSql('ALTER TABLE brother ALTER id TYPE INT');
        $this->addSql('ALTER TABLE brother ALTER congregation_id TYPE INT');
        $this->addSql('ALTER TABLE admin_user ALTER id TYPE INT');
        $this->addSql('ALTER TABLE territory_assignment ALTER id TYPE INT');
        $this->addSql('ALTER TABLE territory_assignment ALTER territory_id TYPE INT');
        $this->addSql('ALTER TABLE territory_assignment ALTER brother_id TYPE INT');
        $this->addSql('ALTER TABLE territory ALTER id TYPE INT');
        $this->addSql('ALTER TABLE territory ALTER congregation_id TYPE INT');
        $this->addSql('ALTER TABLE territory ALTER area_id TYPE INT');
        $this->addSql('ALTER TABLE area ALTER id TYPE INT');
        $this->addSql('ALTER TABLE area ALTER congregation_id TYPE INT');
        $this->addSql('ALTER TABLE area ALTER municipality_id TYPE INT');
        $this->addSql('ALTER TABLE province ALTER id TYPE INT');
        $this->addSql('ALTER TABLE province ALTER congregation_id TYPE INT');
        $this->addSql('ALTER TABLE app_user_invitation ALTER brother_id TYPE INT');
        $this->addSql('ALTER TABLE municipality ALTER id TYPE INT');
        $this->addSql('ALTER TABLE municipality ALTER congregation_id TYPE INT');
        $this->addSql('ALTER TABLE municipality ALTER province_id TYPE INT');
        $this->addSql('ALTER TABLE reset_password_request ALTER id TYPE INT');
        $this->addSql('ALTER TABLE reset_password_request ALTER app_user_id TYPE INT');
        $this->addSql('ALTER TABLE reset_password_request ALTER admin_user_id TYPE INT');
        $this->addSql('ALTER TABLE app_user ALTER id TYPE INT');
        $this->addSql('ALTER TABLE app_user ALTER brother_id TYPE INT');
    }
}
