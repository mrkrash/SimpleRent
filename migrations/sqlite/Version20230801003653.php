<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230801003653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__booked_product AS SELECT id, booking_id, product_id, qty, size, created_at, updated_at FROM booked_product');
        $this->addSql('DROP TABLE booked_product');
        $this->addSql('CREATE TABLE booked_product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, booking_id INTEGER NOT NULL, product_id INTEGER NOT NULL, qty INTEGER NOT NULL, size VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_48D9FA083301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_48D9FA084584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO booked_product (id, booking_id, product_id, qty, size, created_at, updated_at) SELECT id, booking_id, product_id, qty, size, created_at, updated_at FROM __temp__booked_product');
        $this->addSql('DROP TABLE __temp__booked_product');
        $this->addSql('CREATE INDEX IDX_48D9FA083301C60 ON booked_product (booking_id)');
        $this->addSql('CREATE INDEX IDX_48D9FA084584665A ON booked_product (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__booked_product AS SELECT id, booking_id, product_id, qty, size, created_at, updated_at FROM booked_product');
        $this->addSql('DROP TABLE booked_product');
        $this->addSql('CREATE TABLE booked_product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, booking_id INTEGER NOT NULL, product_id INTEGER NOT NULL, qty INTEGER NOT NULL, size VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_48D9FA083301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_48D9FA084584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO booked_product (id, booking_id, product_id, qty, size, created_at, updated_at) SELECT id, booking_id, product_id, qty, size, created_at, updated_at FROM __temp__booked_product');
        $this->addSql('DROP TABLE __temp__booked_product');
        $this->addSql('CREATE INDEX IDX_48D9FA083301C60 ON booked_product (booking_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_48D9FA084584665A ON booked_product (product_id)');
    }
}
