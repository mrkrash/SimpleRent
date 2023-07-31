<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230731232246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add ManyToManyAssociation Booking-Product';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_product (booking_id INTEGER NOT NULL, product_id INTEGER NOT NULL, PRIMARY KEY(booking_id, product_id), CONSTRAINT FK_89F4418D3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_89F4418D4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_89F4418D3301C60 ON booking_product (booking_id)');
        $this->addSql('CREATE INDEX IDX_89F4418D4584665A ON booking_product (product_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__booking AS SELECT id, customer_id, transaction_id, date_start, date_end, notes, created_at, updated_at, deleted_at, rate FROM booking');
        $this->addSql('DROP TABLE booking');
        $this->addSql('CREATE TABLE booking (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_id INTEGER NOT NULL, transaction_id INTEGER DEFAULT NULL, date_start DATE NOT NULL --(DC2Type:date_immutable)
        , date_end DATE NOT NULL --(DC2Type:date_immutable)
        , notes CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, rate INTEGER NOT NULL, CONSTRAINT FK_E00CEDDE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E00CEDDE2FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transations (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO booking (id, customer_id, transaction_id, date_start, date_end, notes, created_at, updated_at, deleted_at, rate) SELECT id, customer_id, transaction_id, date_start, date_end, notes, created_at, updated_at, deleted_at, rate FROM __temp__booking');
        $this->addSql('DROP TABLE __temp__booking');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDE2FC0CB0F ON booking (transaction_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE9395C3F3 ON booking (customer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE booking_product');
        $this->addSql('ALTER TABLE booking ADD COLUMN products CLOB NOT NULL');
        $this->addSql('ALTER TABLE booking ADD COLUMN accessories CLOB NOT NULL');
    }
}
