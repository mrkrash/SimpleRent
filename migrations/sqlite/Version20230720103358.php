<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230720103358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accessory_qty (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, accessory_id INTEGER DEFAULT NULL, size_xs INTEGER NOT NULL, size_s INTEGER NOT NULL, size_m INTEGER NOT NULL, size_l INTEGER NOT NULL, size_xl INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_FDD5D74E27E8CC78 FOREIGN KEY (accessory_id) REFERENCES accessory (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FDD5D74E27E8CC78 ON accessory_qty (accessory_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, price_list_id, name, description, created_at, updated_at, deleted_at, image, gender, enabled, ordering, type FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, price_list_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1500) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, image VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, enabled BOOLEAN NOT NULL, ordering INTEGER NOT NULL, type VARCHAR(7) NOT NULL, CONSTRAINT FK_D34A04AD5688DED7 FOREIGN KEY (price_list_id) REFERENCES price_list (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product (id, price_list_id, name, description, created_at, updated_at, deleted_at, image, gender, enabled, ordering, type) SELECT id, price_list_id, name, description, created_at, updated_at, deleted_at, image, gender, enabled, ordering, type FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04AD5688DED7 ON product (price_list_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE accessory_qty');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, price_list_id, type, name, description, image, gender, enabled, ordering, created_at, updated_at, deleted_at FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, price_list_id INTEGER NOT NULL, type VARCHAR(7) DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1500) DEFAULT NULL, image VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, enabled BOOLEAN NOT NULL, ordering INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_D34A04AD5688DED7 FOREIGN KEY (price_list_id) REFERENCES price_list (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product (id, price_list_id, type, name, description, image, gender, enabled, ordering, created_at, updated_at, deleted_at) SELECT id, price_list_id, type, name, description, image, gender, enabled, ordering, created_at, updated_at, deleted_at FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04AD5688DED7 ON product (price_list_id)');
    }
}
