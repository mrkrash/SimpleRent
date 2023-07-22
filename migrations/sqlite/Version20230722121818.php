<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230722121818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transations (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, transport VARCHAR(6) NOT NULL, transport_id VARCHAR(32) NOT NULL, transport_status VARCHAR(40) NOT NULL, transport_details CLOB NOT NULL --(DC2Type:json)
        , amount INTEGER NOT NULL, levied INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL)');
        $this->addSql('DROP TABLE "transaction"');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "transaction" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, transport VARCHAR(6) NOT NULL COLLATE "BINARY", amount INTEGER NOT NULL, levied INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL COLLATE "BINARY", transport_id VARCHAR(32) NOT NULL COLLATE "BINARY", transport_status VARCHAR(40) NOT NULL COLLATE "BINARY", transport_details CLOB NOT NULL COLLATE "BINARY" --(DC2Type:json)
        )');
        $this->addSql('DROP TABLE transations');
    }
}
