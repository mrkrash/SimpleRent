<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230901163417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__affiliate AS SELECT id, name, address, web, created_at, updated_at, deleted_at, image FROM affiliate');
        $this->addSql('DROP TABLE affiliate');
        $this->addSql('CREATE TABLE affiliate (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, web VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, image VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO affiliate (id, name, address, web, created_at, updated_at, deleted_at, image) SELECT id, name, address, web, created_at, updated_at, deleted_at, image FROM __temp__affiliate');
        $this->addSql('DROP TABLE __temp__affiliate');
        $this->addSql('CREATE TEMPORARY TABLE __temp__price_list AS SELECT id, name, created_at, updated_at, deleted_at, price_one_day, price_three_days, price_seven_days FROM price_list');
        $this->addSql('DROP TABLE price_list');
        $this->addSql('CREATE TABLE price_list (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, price_one_day INTEGER NOT NULL, price_three_days INTEGER NOT NULL, price_seven_days INTEGER NOT NULL)');
        $this->addSql('INSERT INTO price_list (id, name, created_at, updated_at, deleted_at, price_one_day, price_three_days, price_seven_days) SELECT id, name, created_at, updated_at, deleted_at, price_one_day, price_three_days, price_seven_days FROM __temp__price_list');
        $this->addSql('DROP TABLE __temp__price_list');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product_qty AS SELECT id, product_id, created_at, updated_at, deleted_at, size, qty FROM product_qty');
        $this->addSql('DROP TABLE product_qty');
        $this->addSql('CREATE TABLE product_qty (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_id INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, size VARCHAR(255) NOT NULL, qty INTEGER NOT NULL, CONSTRAINT FK_28D7FA004584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product_qty (id, product_id, created_at, updated_at, deleted_at, size, qty) SELECT id, product_id, created_at, updated_at, deleted_at, size, qty FROM __temp__product_qty');
        $this->addSql('DROP TABLE __temp__product_qty');
        $this->addSql('CREATE INDEX IDX_28D7FA004584665A ON product_qty (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__affiliate AS SELECT id, name, address, web, image, created_at, updated_at, deleted_at FROM affiliate');
        $this->addSql('DROP TABLE affiliate');
        $this->addSql('CREATE TABLE affiliate (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, web VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO affiliate (id, name, address, web, image, created_at, updated_at, deleted_at) SELECT id, name, address, web, image, created_at, updated_at, deleted_at FROM __temp__affiliate');
        $this->addSql('DROP TABLE __temp__affiliate');
        $this->addSql('ALTER TABLE price_list ADD COLUMN price_half_day INTEGER NOT NULL');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product_qty AS SELECT id, product_id, size, qty, created_at, updated_at, deleted_at FROM product_qty');
        $this->addSql('DROP TABLE product_qty');
        $this->addSql('CREATE TABLE product_qty (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_id INTEGER DEFAULT NULL, size VARCHAR(255) NOT NULL, qty INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_28D7FA004584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product_qty (id, product_id, size, qty, created_at, updated_at, deleted_at) SELECT id, product_id, size, qty, created_at, updated_at, deleted_at FROM __temp__product_qty');
        $this->addSql('DROP TABLE __temp__product_qty');
        $this->addSql('CREATE INDEX IDX_28D7FA004584665A ON product_qty (product_id)');
    }
}
