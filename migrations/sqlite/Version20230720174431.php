<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230720174431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accessory_qty ADD COLUMN size36 INTEGER NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE accessory_qty ADD COLUMN size37 INTEGER NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE accessory_qty ADD COLUMN size38 INTEGER NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE accessory_qty ADD COLUMN size39 INTEGER NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE accessory_qty ADD COLUMN size40 INTEGER NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE accessory_qty ADD COLUMN size41 INTEGER NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE accessory_qty ADD COLUMN size42 INTEGER NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE accessory_qty ADD COLUMN size43 INTEGER NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE accessory_qty ADD COLUMN size44 INTEGER NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE accessory_qty ADD COLUMN size45 INTEGER NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE accessory_qty ADD COLUMN size46 INTEGER NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE accessory_qty ADD COLUMN size47 INTEGER NOT NULL DEFAULT 0');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__accessory_qty AS SELECT id, accessory_id, size_xs, size_s, size_m, size_l, size_xl, created_at, updated_at, deleted_at FROM accessory_qty');
        $this->addSql('DROP TABLE accessory_qty');
        $this->addSql('CREATE TABLE accessory_qty (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, accessory_id INTEGER DEFAULT NULL, size_xs INTEGER NOT NULL, size_s INTEGER NOT NULL, size_m INTEGER NOT NULL, size_l INTEGER NOT NULL, size_xl INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_FDD5D74E27E8CC78 FOREIGN KEY (accessory_id) REFERENCES accessory (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO accessory_qty (id, accessory_id, size_xs, size_s, size_m, size_l, size_xl, created_at, updated_at, deleted_at) SELECT id, accessory_id, size_xs, size_s, size_m, size_l, size_xl, created_at, updated_at, deleted_at FROM __temp__accessory_qty');
        $this->addSql('DROP TABLE __temp__accessory_qty');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FDD5D74E27E8CC78 ON accessory_qty (accessory_id)');
    }
}
