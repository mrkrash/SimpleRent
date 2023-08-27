<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230819074906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Move to rational warehouse';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TEMPORARY TABLE __temp__product_qty AS SELECT id, product_id, size_xs, size_s, size_m, size_l, size_xl, created_at, updated_at, deleted_at FROM product_qty');
        $this->addSql('DROP TABLE product_qty');
        $this->addSql('CREATE TABLE product_qty (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, size VARCHAR(255) NOT NULL, qty INTEGER NOT NULL, CONSTRAINT FK_28D7FA004584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT product_id, "XS", size_xs, created_at, updated_at, deleted_at FROM __temp__product_qty WHERE size_xs > 0');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT product_id, "S", size_s, created_at, updated_at, deleted_at FROM __temp__product_qty WHERE size_s > 0');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT product_id, "M", size_m, created_at, updated_at, deleted_at FROM __temp__product_qty WHERE size_m > 0');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT product_id, "L", size_l, created_at, updated_at, deleted_at FROM __temp__product_qty WHERE size_l > 0');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT product_id, "XL", size_xl, created_at, updated_at, deleted_at FROM __temp__product_qty WHERE size_xl > 0');

        // This is incorrect but...
        $this->addSql('INSERT INTO price_list (name, price_half_day, price_one_day, price_three_days, price_seven_days, created_at, updated_at) VALUES ("Accessori 1", 0, 300, 300, 2000, "20230819T102300", "20230819T102300")');
        $this->addSql('INSERT INTO price_list (name, price_half_day, price_one_day, price_three_days, price_seven_days, created_at, updated_at) VALUES ("Accessori 2", 0, 500, 500, 3000, "20230819T102300", "20230819T102300")');

        $this->addSql('INSERT INTO product (name, description, image, gender, enabled, ordering, type, price_list_id, created_at, updated_at, deleted_at) SELECT a.name, a.description, a.image, "Unisex", 1, 0, "Accessory", pl.id, a.created_at, a.updated_at, a.deleted_at FROM accessory a, price_list pl WHERE a.daily_price = pl.price_one_day AND a.daily_price = pl.price_three_days');
        $this->addSql('INSERT INTO product (name, description, image, gender, enabled, ordering, type, price_list_id, created_at, updated_at, deleted_at) SELECT a.name, a.description, a.image, "Unisex", 1, 0, "Accessory", pl.id, a.created_at, a.updated_at, a.deleted_at FROM accessory a, price_list pl WHERE a.daily_price = pl.price_one_day AND a.daily_price = pl.price_three_days');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT p.id, "XS", aq.size_xs, aq.created_at, aq.updated_at, aq.deleted_at FROM accessory_qty aq, accessory a, product p WHERE aq.size_xs > 0 AND a.name = p.name AND a.description = p.description');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT p.id, "S", aq.size_s, aq.created_at, aq.updated_at, aq.deleted_at FROM accessory_qty aq, accessory a, product p WHERE aq.size_s > 0 AND a.name = p.name AND a.description = p.description');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT p.id, "M", aq.size_m, aq.created_at, aq.updated_at, aq.deleted_at FROM accessory_qty aq, accessory a, product p WHERE aq.size_m > 0 AND a.name = p.name AND a.description = p.description');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT p.id, "L", aq.size_l, aq.created_at, aq.updated_at, aq.deleted_at FROM accessory_qty aq, accessory a, product p WHERE aq.size_l > 0 AND a.name = p.name AND a.description = p.description');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT p.id, "XL", aq.size_xl, aq.created_at, aq.updated_at, aq.deleted_at FROM accessory_qty aq, accessory a, product p WHERE aq.size_xl > 0 AND a.name = p.name AND a.description = p.description');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT p.id, "36", aq.size36, aq.created_at, aq.updated_at, aq.deleted_at FROM accessory_qty aq, accessory a, product p WHERE aq.size36 > 0 AND a.name = p.name AND a.description = p.description');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT p.id, "37", aq.size37, aq.created_at, aq.updated_at, aq.deleted_at FROM accessory_qty aq, accessory a, product p WHERE aq.size37 > 0 AND a.name = p.name AND a.description = p.description');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT p.id, "38", aq.size38, aq.created_at, aq.updated_at, aq.deleted_at FROM accessory_qty aq, accessory a, product p WHERE aq.size38 > 0 AND a.name = p.name AND a.description = p.description');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT p.id, "39", aq.size39, aq.created_at, aq.updated_at, aq.deleted_at FROM accessory_qty aq, accessory a, product p WHERE aq.size39 > 0 AND a.name = p.name AND a.description = p.description');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT p.id, "40", aq.size40, aq.created_at, aq.updated_at, aq.deleted_at FROM accessory_qty aq, accessory a, product p WHERE aq.size40 > 0 AND a.name = p.name AND a.description = p.description');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT p.id, "40", aq.size41, aq.created_at, aq.updated_at, aq.deleted_at FROM accessory_qty aq, accessory a, product p WHERE aq.size41 > 0 AND a.name = p.name AND a.description = p.description');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT p.id, "40", aq.size42, aq.created_at, aq.updated_at, aq.deleted_at FROM accessory_qty aq, accessory a, product p WHERE aq.size42 > 0 AND a.name = p.name AND a.description = p.description');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT p.id, "40", aq.size43, aq.created_at, aq.updated_at, aq.deleted_at FROM accessory_qty aq, accessory a, product p WHERE aq.size43 > 0 AND a.name = p.name AND a.description = p.description');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT p.id, "40", aq.size44, aq.created_at, aq.updated_at, aq.deleted_at FROM accessory_qty aq, accessory a, product p WHERE aq.size44 > 0 AND a.name = p.name AND a.description = p.description');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT p.id, "40", aq.size45, aq.created_at, aq.updated_at, aq.deleted_at FROM accessory_qty aq, accessory a, product p WHERE aq.size45 > 0 AND a.name = p.name AND a.description = p.description');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT p.id, "40", aq.size46, aq.created_at, aq.updated_at, aq.deleted_at FROM accessory_qty aq, accessory a, product p WHERE aq.size46 > 0 AND a.name = p.name AND a.description = p.description');
        $this->addSql('INSERT INTO product_qty (product_id, size, qty, created_at, updated_at, deleted_at) SELECT p.id, "40", aq.size47, aq.created_at, aq.updated_at, aq.deleted_at FROM accessory_qty aq, accessory a, product p WHERE aq.size47 > 0 AND a.name = p.name AND a.description = p.description');

        $this->addSql('DROP TABLE accessory');
        $this->addSql('DROP TABLE accessory_qty');

        $this->addSql('DROP TABLE __temp__product_qty');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TEMPORARY TABLE __temp__product_qty AS SELECT id, product_id, qty, created_at, updated_at, deleted_at FROM product_qty');
        $this->addSql('DROP TABLE product_qty');
        $this->addSql('CREATE TABLE product_qty (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_id INTEGER DEFAULT NULL, size_xs INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, size_s INTEGER NOT NULL, size_m INTEGER NOT NULL, size_l INTEGER NOT NULL, size_xl INTEGER NOT NULL, CONSTRAINT FK_28D7FA004584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product_qty (id, product_id, size_xs, created_at, updated_at, deleted_at) SELECT id, product_id, qty, created_at, updated_at, deleted_at FROM __temp__product_qty');
        $this->addSql('DROP TABLE __temp__product_qty');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_28D7FA004584665A ON product_qty (product_id)');
    }
}
