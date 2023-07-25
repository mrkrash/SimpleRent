<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230725083808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__booking AS SELECT id, customer_id, date_start, date_end, notes, created_at, updated_at, deleted_at, products, accessories, rate FROM booking');
        $this->addSql('DROP TABLE booking');
        $this->addSql('CREATE TABLE booking (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER NOT NULL, transaction_id INTEGER DEFAULT NULL, date_start DATE NOT NULL --(DC2Type:date_immutable)
        , date_end DATE NOT NULL --(DC2Type:date_immutable)
        , notes CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, products CLOB NOT NULL --(DC2Type:json)
        , accessories CLOB NOT NULL --(DC2Type:json)
        , rate INTEGER NOT NULL, CONSTRAINT FK_E00CEDDE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E00CEDDE2FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transations (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO booking (id, customer_id, date_start, date_end, notes, created_at, updated_at, deleted_at, products, accessories, rate) SELECT id, customer_id, date_start, date_end, notes, created_at, updated_at, deleted_at, products, accessories, rate FROM __temp__booking');
        $this->addSql('DROP TABLE __temp__booking');
        $this->addSql('CREATE INDEX IDX_E00CEDDE9395C3F3 ON booking (customer_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDE2FC0CB0F ON booking (transaction_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__booking AS SELECT id, customer_id, date_start, date_end, notes, products, accessories, rate, created_at, updated_at, deleted_at FROM booking');
        $this->addSql('DROP TABLE booking');
        $this->addSql('CREATE TABLE booking (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER NOT NULL, date_start DATE NOT NULL --(DC2Type:date_immutable)
        , date_end DATE NOT NULL --(DC2Type:date_immutable)
        , notes CLOB DEFAULT NULL, products CLOB NOT NULL --(DC2Type:json)
        , accessories CLOB NOT NULL --(DC2Type:json)
        , rate INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_E00CEDDE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO booking (id, customer_id, date_start, date_end, notes, products, accessories, rate, created_at, updated_at, deleted_at) SELECT id, customer_id, date_start, date_end, notes, products, accessories, rate, created_at, updated_at, deleted_at FROM __temp__booking');
        $this->addSql('DROP TABLE __temp__booking');
        $this->addSql('CREATE INDEX IDX_E00CEDDE9395C3F3 ON booking (customer_id)');
    }
}
