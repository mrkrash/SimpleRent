<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230714220744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_product (booking_id INTEGER NOT NULL, product_id INTEGER NOT NULL, PRIMARY KEY(booking_id, product_id), CONSTRAINT FK_89F4418D3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_89F4418D4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_89F4418D3301C60 ON booking_product (booking_id)');
        $this->addSql('CREATE INDEX IDX_89F4418D4584665A ON booking_product (product_id)');
        $this->addSql('CREATE TABLE booking_accessory (booking_id INTEGER NOT NULL, accessory_id INTEGER NOT NULL, PRIMARY KEY(booking_id, accessory_id), CONSTRAINT FK_3283EE1F3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3283EE1F27E8CC78 FOREIGN KEY (accessory_id) REFERENCES accessory (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3283EE1F3301C60 ON booking_accessory (booking_id)');
        $this->addSql('CREATE INDEX IDX_3283EE1F27E8CC78 ON booking_accessory (accessory_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__accessory AS SELECT id, name, description, price, created_at, updated_at, deleted_at, image FROM accessory');
        $this->addSql('DROP TABLE accessory');
        $this->addSql('CREATE TABLE accessory (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1000) DEFAULT NULL, price INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, image VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO accessory (id, name, description, price, created_at, updated_at, deleted_at, image) SELECT id, name, description, price, created_at, updated_at, deleted_at, image FROM __temp__accessory');
        $this->addSql('DROP TABLE __temp__accessory');
        $this->addSql('CREATE TEMPORARY TABLE __temp__booking AS SELECT id, customer_id, payment_transaction_id, date_start, date_end, notes FROM booking');
        $this->addSql('DROP TABLE booking');
        $this->addSql('CREATE TABLE booking (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER NOT NULL, payment_transaction_id INTEGER NOT NULL, date_start DATE NOT NULL --(DC2Type:date_immutable)
        , date_end DATE NOT NULL --(DC2Type:date_immutable)
        , notes CLOB DEFAULT NULL, CONSTRAINT FK_E00CEDDE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E00CEDDECAE8710B FOREIGN KEY (payment_transaction_id) REFERENCES "transaction" (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO booking (id, customer_id, payment_transaction_id, date_start, date_end, notes) SELECT id, customer_id, payment_transaction_id, date_start, date_end, notes FROM __temp__booking');
        $this->addSql('DROP TABLE __temp__booking');
        $this->addSql('CREATE INDEX IDX_E00CEDDE9395C3F3 ON booking (customer_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDECAE8710B ON booking (payment_transaction_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE booking_product');
        $this->addSql('DROP TABLE booking_accessory');
        $this->addSql('CREATE TEMPORARY TABLE __temp__accessory AS SELECT id, name, description, image, price, created_at, updated_at, deleted_at FROM accessory');
        $this->addSql('DROP TABLE accessory');
        $this->addSql('CREATE TABLE accessory (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1000) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, price INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO accessory (id, name, description, image, price, created_at, updated_at, deleted_at) SELECT id, name, description, image, price, created_at, updated_at, deleted_at FROM __temp__accessory');
        $this->addSql('DROP TABLE __temp__accessory');
        $this->addSql('CREATE TEMPORARY TABLE __temp__booking AS SELECT id, customer_id, payment_transaction_id, date_start, date_end, notes FROM booking');
        $this->addSql('DROP TABLE booking');
        $this->addSql('CREATE TABLE booking (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER NOT NULL, payment_transaction_id INTEGER NOT NULL, product_id INTEGER NOT NULL, date_start DATE NOT NULL --(DC2Type:date_immutable)
        , date_end DATE NOT NULL --(DC2Type:date_immutable)
        , notes CLOB DEFAULT NULL, CONSTRAINT FK_E00CEDDE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E00CEDDECAE8710B FOREIGN KEY (payment_transaction_id) REFERENCES "transaction" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E00CEDDE4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO booking (id, customer_id, payment_transaction_id, date_start, date_end, notes) SELECT id, customer_id, payment_transaction_id, date_start, date_end, notes FROM __temp__booking');
        $this->addSql('DROP TABLE __temp__booking');
        $this->addSql('CREATE INDEX IDX_E00CEDDE9395C3F3 ON booking (customer_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDECAE8710B ON booking (payment_transaction_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE4584665A ON booking (product_id)');
    }
}
