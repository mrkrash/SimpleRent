<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230719233517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Split qty and product';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE product ADD COLUMN type VARCHAR(7) DEFAULT NULL');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product_qty AS SELECT id, product_id, size_xs, size_s, size_m, size_l, size_xl, created_at, updated_at, deleted_at FROM product_qty');
        $this->addSql('DROP TABLE product_qty');
        $this->addSql('CREATE TABLE product_qty (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_id INTEGER DEFAULT NULL, size_xs INTEGER NOT NULL, size_s INTEGER NOT NULL, size_m INTEGER NOT NULL, size_l INTEGER NOT NULL, size_xl INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_28D7FA004584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product_qty (id, product_id, size_xs, size_s, size_m, size_l, size_xl, created_at, updated_at, deleted_at) SELECT id, product_id, size_xs, size_s, size_m, size_l, size_xl, created_at, updated_at, deleted_at FROM __temp__product_qty');
        $this->addSql('DROP TABLE __temp__product_qty');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_28D7FA004584665A ON product_qty (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, price_list_id, name, description, image, gender, enabled, ordering, created_at, updated_at, deleted_at FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, price_list_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1500) DEFAULT NULL, image VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, enabled BOOLEAN NOT NULL, ordering INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_D34A04AD5688DED7 FOREIGN KEY (price_list_id) REFERENCES price_list (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product (id, price_list_id, name, description, image, gender, enabled, ordering, created_at, updated_at, deleted_at) SELECT id, price_list_id, name, description, image, gender, enabled, ordering, created_at, updated_at, deleted_at FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04AD5688DED7 ON product (price_list_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product_qty AS SELECT id, product_id, size_xs, size_s, size_m, size_l, size_xl, created_at, updated_at, deleted_at FROM product_qty');
        $this->addSql('DROP TABLE product_qty');
        $this->addSql('CREATE TABLE product_qty (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_id INTEGER NOT NULL, size_xs INTEGER NOT NULL, size_s INTEGER NOT NULL, size_m INTEGER NOT NULL, size_l INTEGER NOT NULL, size_xl INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_28D7FA004584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product_qty (id, product_id, size_xs, size_s, size_m, size_l, size_xl, created_at, updated_at, deleted_at) SELECT id, product_id, size_xs, size_s, size_m, size_l, size_xl, created_at, updated_at, deleted_at FROM __temp__product_qty');
        $this->addSql('DROP TABLE __temp__product_qty');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_28D7FA004584665A ON product_qty (product_id)');
    }
}
