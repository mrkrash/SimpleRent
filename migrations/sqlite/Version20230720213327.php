<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230720213327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__booking AS SELECT id, customer_id, date_start, date_end, notes, created_at, updated_at, deleted_at, products, accessories FROM booking');
        $this->addSql('DROP TABLE booking');
        $this->addSql('CREATE TABLE booking (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER NOT NULL, date_start DATE NOT NULL --(DC2Type:date_immutable)
        , date_end DATE NOT NULL --(DC2Type:date_immutable)
        , notes CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, products CLOB NOT NULL --(DC2Type:json)
        , accessories CLOB NOT NULL --(DC2Type:json)
        , CONSTRAINT FK_E00CEDDE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO booking (id, customer_id, date_start, date_end, notes, created_at, updated_at, deleted_at, products, accessories) SELECT id, customer_id, date_start, date_end, notes, created_at, updated_at, deleted_at, products, accessories FROM __temp__booking');
        $this->addSql('DROP TABLE __temp__booking');
        $this->addSql('CREATE INDEX IDX_E00CEDDE9395C3F3 ON booking (customer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__booking AS SELECT id, customer_id, date_start, date_end, notes, products, accessories, created_at, updated_at, deleted_at FROM booking');
        $this->addSql('DROP TABLE booking');
        $this->addSql('CREATE TABLE booking (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER NOT NULL, date_start DATE NOT NULL --(DC2Type:date_immutable)
        , date_end DATE NOT NULL --(DC2Type:date_immutable)
        , notes CLOB DEFAULT NULL, products CLOB NOT NULL --(DC2Type:json)
        , accessories VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_E00CEDDE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO booking (id, customer_id, date_start, date_end, notes, products, accessories, created_at, updated_at, deleted_at) SELECT id, customer_id, date_start, date_end, notes, products, accessories, created_at, updated_at, deleted_at FROM __temp__booking');
        $this->addSql('DROP TABLE __temp__booking');
        $this->addSql('CREATE INDEX IDX_E00CEDDE9395C3F3 ON booking (customer_id)');
    }
}
