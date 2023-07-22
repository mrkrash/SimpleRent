<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230720211540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE booking_accessory');
        $this->addSql('DROP TABLE booking_product');
        $this->addSql('CREATE TEMPORARY TABLE __temp__accessory_qty AS SELECT id, accessory_id, size_xs, size_s, size_m, size_l, size_xl, created_at, updated_at, deleted_at, size36, size37, size38, size39, size40, size41, size42, size43, size44, size45, size46, size47 FROM accessory_qty');
        $this->addSql('DROP TABLE accessory_qty');
        $this->addSql('CREATE TABLE accessory_qty (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, accessory_id INTEGER DEFAULT NULL, size_xs INTEGER NOT NULL, size_s INTEGER NOT NULL, size_m INTEGER NOT NULL, size_l INTEGER NOT NULL, size_xl INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, size36 INTEGER NOT NULL, size37 INTEGER NOT NULL, size38 INTEGER NOT NULL, size39 INTEGER NOT NULL, size40 INTEGER NOT NULL, size41 INTEGER NOT NULL, size42 INTEGER NOT NULL, size43 INTEGER NOT NULL, size44 INTEGER NOT NULL, size45 INTEGER NOT NULL, size46 INTEGER NOT NULL, size47 INTEGER NOT NULL, CONSTRAINT FK_FDD5D74E27E8CC78 FOREIGN KEY (accessory_id) REFERENCES accessory (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO accessory_qty (id, accessory_id, size_xs, size_s, size_m, size_l, size_xl, created_at, updated_at, deleted_at, size36, size37, size38, size39, size40, size41, size42, size43, size44, size45, size46, size47) SELECT id, accessory_id, size_xs, size_s, size_m, size_l, size_xl, created_at, updated_at, deleted_at, size36, size37, size38, size39, size40, size41, size42, size43, size44, size45, size46, size47 FROM __temp__accessory_qty');
        $this->addSql('DROP TABLE __temp__accessory_qty');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FDD5D74E27E8CC78 ON accessory_qty (accessory_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__booking AS SELECT id, customer_id, date_start, date_end, notes, created_at, updated_at, deleted_at FROM booking');
        $this->addSql('DROP TABLE booking');
        $this->addSql('CREATE TABLE booking (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER NOT NULL, date_start DATE NOT NULL --(DC2Type:date_immutable)
        , date_end DATE NOT NULL --(DC2Type:date_immutable)
        , notes CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, products VARCHAR(255) NOT NULL, accessories VARCHAR(255) NOT NULL, CONSTRAINT FK_E00CEDDE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO booking (id, customer_id, date_start, date_end, notes, created_at, updated_at, deleted_at) SELECT id, customer_id, date_start, date_end, notes, created_at, updated_at, deleted_at FROM __temp__booking');
        $this->addSql('DROP TABLE __temp__booking');
        $this->addSql('CREATE INDEX IDX_E00CEDDE9395C3F3 ON booking (customer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_accessory (booking_id INTEGER NOT NULL, accessory_id INTEGER NOT NULL, PRIMARY KEY(booking_id, accessory_id), CONSTRAINT FK_3283EE1F3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3283EE1F27E8CC78 FOREIGN KEY (accessory_id) REFERENCES accessory (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3283EE1F27E8CC78 ON booking_accessory (accessory_id)');
        $this->addSql('CREATE INDEX IDX_3283EE1F3301C60 ON booking_accessory (booking_id)');
        $this->addSql('CREATE TABLE booking_product (booking_id INTEGER NOT NULL, product_id INTEGER NOT NULL, PRIMARY KEY(booking_id, product_id), CONSTRAINT FK_89F4418D3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_89F4418D4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_89F4418D4584665A ON booking_product (product_id)');
        $this->addSql('CREATE INDEX IDX_89F4418D3301C60 ON booking_product (booking_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__accessory_qty AS SELECT id, accessory_id, size_xs, size_s, size_m, size_l, size_xl, size36, size37, size38, size39, size40, size41, size42, size43, size44, size45, size46, size47, created_at, updated_at, deleted_at FROM accessory_qty');
        $this->addSql('DROP TABLE accessory_qty');
        $this->addSql('CREATE TABLE accessory_qty (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, accessory_id INTEGER DEFAULT NULL, size_xs INTEGER NOT NULL, size_s INTEGER NOT NULL, size_m INTEGER NOT NULL, size_l INTEGER NOT NULL, size_xl INTEGER NOT NULL, size36 INTEGER DEFAULT 0 NOT NULL, size37 INTEGER DEFAULT 0 NOT NULL, size38 INTEGER DEFAULT 0 NOT NULL, size39 INTEGER DEFAULT 0 NOT NULL, size40 INTEGER DEFAULT 0 NOT NULL, size41 INTEGER DEFAULT 0 NOT NULL, size42 INTEGER DEFAULT 0 NOT NULL, size43 INTEGER DEFAULT 0 NOT NULL, size44 INTEGER DEFAULT 0 NOT NULL, size45 INTEGER DEFAULT 0 NOT NULL, size46 INTEGER DEFAULT 0 NOT NULL, size47 INTEGER DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_FDD5D74E27E8CC78 FOREIGN KEY (accessory_id) REFERENCES accessory (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO accessory_qty (id, accessory_id, size_xs, size_s, size_m, size_l, size_xl, size36, size37, size38, size39, size40, size41, size42, size43, size44, size45, size46, size47, created_at, updated_at, deleted_at) SELECT id, accessory_id, size_xs, size_s, size_m, size_l, size_xl, size36, size37, size38, size39, size40, size41, size42, size43, size44, size45, size46, size47, created_at, updated_at, deleted_at FROM __temp__accessory_qty');
        $this->addSql('DROP TABLE __temp__accessory_qty');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FDD5D74E27E8CC78 ON accessory_qty (accessory_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__booking AS SELECT id, customer_id, date_start, date_end, notes, created_at, updated_at, deleted_at FROM booking');
        $this->addSql('DROP TABLE booking');
        $this->addSql('CREATE TABLE booking (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER NOT NULL, payment_transaction_id INTEGER NOT NULL, date_start DATE NOT NULL --(DC2Type:date_immutable)
        , date_end DATE NOT NULL --(DC2Type:date_immutable)
        , notes CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_E00CEDDE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E00CEDDECAE8710B FOREIGN KEY (payment_transaction_id) REFERENCES "transaction" (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO booking (id, customer_id, date_start, date_end, notes, created_at, updated_at, deleted_at) SELECT id, customer_id, date_start, date_end, notes, created_at, updated_at, deleted_at FROM __temp__booking');
        $this->addSql('DROP TABLE __temp__booking');
        $this->addSql('CREATE INDEX IDX_E00CEDDE9395C3F3 ON booking (customer_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDECAE8710B ON booking (payment_transaction_id)');
    }
}
