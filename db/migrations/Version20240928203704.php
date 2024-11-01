<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240928203704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, email VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, is_confirmed BOOLEAN NOT NULL, is_admin BOOLEAN NOT NULL, hash UUID NOT NULL, create_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "user".hash IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "user".create_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('DROP TABLE user_table');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE user_table (id UUID NOT NULL, email VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, is_confirmed BOOLEAN NOT NULL, is_admin BOOLEAN NOT NULL, hash UUID NOT NULL, create_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN user_table.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_table.hash IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_table.create_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('DROP TABLE "user"');
    }
}
