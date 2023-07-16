<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230715234657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__booking AS SELECT id, customer_id, payment_transaction_id, date_start, date_end, notes, created_at, updated_at, deleted_at FROM booking');
        $this->addSql('DROP TABLE booking');
        $this->addSql('CREATE TABLE booking (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER NOT NULL, payment_transaction_id INTEGER NOT NULL, date_start DATE NOT NULL --(DC2Type:date_immutable)
        , date_end DATE NOT NULL --(DC2Type:date_immutable)
        , notes CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_E00CEDDE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E00CEDDECAE8710B FOREIGN KEY (payment_transaction_id) REFERENCES "transaction" (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO booking (id, customer_id, payment_transaction_id, date_start, date_end, notes, created_at, updated_at, deleted_at) SELECT id, customer_id, payment_transaction_id, date_start, date_end, notes, created_at, updated_at, deleted_at FROM __temp__booking');
        $this->addSql('DROP TABLE __temp__booking');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDECAE8710B ON booking (payment_transaction_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE9395C3F3 ON booking (customer_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer AS SELECT id, firstname, lastname, email, phone, created_at, updated_at, deleted_at FROM customer');
        $this->addSql('DROP TABLE customer');
        $this->addSql('CREATE TABLE customer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, email VARCHAR(150) NOT NULL, phone VARCHAR(15) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO customer (id, firstname, lastname, email, phone, created_at, updated_at, deleted_at) SELECT id, firstname, lastname, email, phone, created_at, updated_at, deleted_at FROM __temp__customer');
        $this->addSql('DROP TABLE __temp__customer');
        $this->addSql('CREATE TEMPORARY TABLE __temp__price_list AS SELECT id, name, created_at, updated_at, deleted_at FROM price_list');
        $this->addSql('DROP TABLE price_list');
        $this->addSql('CREATE TABLE price_list (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, price_half_day INTEGER NOT NULL, price_one_day INTEGER NOT NULL, price_three_days INTEGER NOT NULL, price_seven_days INTEGER NOT NULL)');
        $this->addSql('INSERT INTO price_list (id, name, created_at, updated_at, deleted_at) SELECT id, name, created_at, updated_at, deleted_at FROM __temp__price_list');
        $this->addSql('DROP TABLE __temp__price_list');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__booking AS SELECT id, customer_id, payment_transaction_id, date_start, date_end, notes, created_at, updated_at, deleted_at FROM booking');
        $this->addSql('DROP TABLE booking');
        $this->addSql('CREATE TABLE booking (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER NOT NULL, payment_transaction_id INTEGER NOT NULL, date_start DATE NOT NULL --(DC2Type:date_immutable)
        , date_end DATE NOT NULL --(DC2Type:date_immutable)
        , notes CLOB DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_E00CEDDE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E00CEDDECAE8710B FOREIGN KEY (payment_transaction_id) REFERENCES "transaction" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO booking (id, customer_id, payment_transaction_id, date_start, date_end, notes, created_at, updated_at, deleted_at) SELECT id, customer_id, payment_transaction_id, date_start, date_end, notes, created_at, updated_at, deleted_at FROM __temp__booking');
        $this->addSql('DROP TABLE __temp__booking');
        $this->addSql('CREATE INDEX IDX_E00CEDDE9395C3F3 ON booking (customer_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDECAE8710B ON booking (payment_transaction_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer AS SELECT id, firstname, lastname, email, phone, created_at, updated_at, deleted_at FROM customer');
        $this->addSql('DROP TABLE customer');
        $this->addSql('CREATE TABLE customer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, email VARCHAR(150) NOT NULL, phone VARCHAR(15) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO customer (id, firstname, lastname, email, phone, created_at, updated_at, deleted_at) SELECT id, firstname, lastname, email, phone, created_at, updated_at, deleted_at FROM __temp__customer');
        $this->addSql('DROP TABLE __temp__customer');
        $this->addSql('CREATE TEMPORARY TABLE __temp__price_list AS SELECT id, name, created_at, updated_at, deleted_at FROM price_list');
        $this->addSql('DROP TABLE price_list');
        $this->addSql('CREATE TABLE price_list (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, price INTEGER NOT NULL, price3days INTEGER NOT NULL, price7days INTEGER NOT NULL, half_day INTEGER NOT NULL)');
        $this->addSql('INSERT INTO price_list (id, name, created_at, updated_at, deleted_at) SELECT id, name, created_at, updated_at, deleted_at FROM __temp__price_list');
        $this->addSql('DROP TABLE __temp__price_list');
    }
}
