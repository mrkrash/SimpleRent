<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230725081444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transations ADD COLUMN request_id VARCHAR(36) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__transations AS SELECT id, transport, transport_id, transport_status, transport_details, amount, levied, created_at, updated_at, deleted_at FROM transations');
        $this->addSql('DROP TABLE transations');
        $this->addSql('CREATE TABLE transations (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, transport VARCHAR(6) NOT NULL, transport_id VARCHAR(32) NOT NULL, transport_status VARCHAR(40) NOT NULL, transport_details CLOB NOT NULL --(DC2Type:json)
        , amount INTEGER NOT NULL, levied INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO transations (id, transport, transport_id, transport_status, transport_details, amount, levied, created_at, updated_at, deleted_at) SELECT id, transport, transport_id, transport_status, transport_details, amount, levied, created_at, updated_at, deleted_at FROM __temp__transations');
        $this->addSql('DROP TABLE __temp__transations');
    }
}
