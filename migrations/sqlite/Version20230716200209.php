<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230716200209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(50) NOT NULL, content VARCHAR(3000) NOT NULL, lang VARCHAR(2) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL)');
        $this->addSql('ALTER TABLE product ADD COLUMN enabled BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE product ADD COLUMN ordering INTEGER NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE page');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, price_list_id, name, description, image, qty, size, gender, created_at, updated_at, deleted_at FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, price_list_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1500) DEFAULT NULL, image VARCHAR(255) NOT NULL, qty INTEGER NOT NULL, size VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_D34A04AD5688DED7 FOREIGN KEY (price_list_id) REFERENCES price_list (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product (id, price_list_id, name, description, image, qty, size, gender, created_at, updated_at, deleted_at) SELECT id, price_list_id, name, description, image, qty, size, gender, created_at, updated_at, deleted_at FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04AD5688DED7 ON product (price_list_id)');
    }
}
