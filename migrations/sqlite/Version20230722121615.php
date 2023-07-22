<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230722121615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__transaction AS SELECT id, transport, amount, levied, created_at, updated_at, deleted_at FROM "transaction"');
        $this->addSql('DROP TABLE "transaction"');
        $this->addSql('CREATE TABLE "transaction" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, transport VARCHAR(6) NOT NULL, amount INTEGER NOT NULL, levied INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, transport_id VARCHAR(32) NOT NULL, transport_status VARCHAR(40) NOT NULL, transport_details CLOB NOT NULL --(DC2Type:json)
        )');
        $this->addSql('INSERT INTO "transaction" (id, transport, amount, levied, created_at, updated_at, deleted_at) SELECT id, transport, amount, levied, created_at, updated_at, deleted_at FROM __temp__transaction');
        $this->addSql('DROP TABLE __temp__transaction');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__transaction AS SELECT id, transport, amount, levied, created_at, updated_at, deleted_at FROM "transaction"');
        $this->addSql('DROP TABLE "transaction"');
        $this->addSql('CREATE TABLE "transaction" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, transport VARCHAR(10) NOT NULL, amount INTEGER NOT NULL, levied INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, serial VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO "transaction" (id, transport, amount, levied, created_at, updated_at, deleted_at) SELECT id, transport, amount, levied, created_at, updated_at, deleted_at FROM __temp__transaction');
        $this->addSql('DROP TABLE __temp__transaction');
    }
}
