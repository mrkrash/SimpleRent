<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230728190754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__page AS SELECT id, title, content, lang, created_at, updated_at, deleted_at, slug FROM page');
        $this->addSql('DROP TABLE page');
        $this->addSql('CREATE TABLE page (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(50) NOT NULL, content CLOB NOT NULL, lang VARCHAR(2) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL, slug VARCHAR(50) NOT NULL)');
        $this->addSql('INSERT INTO page (id, title, content, lang, created_at, updated_at, deleted_at, slug) SELECT id, title, content, lang, created_at, updated_at, deleted_at, slug FROM __temp__page');
        $this->addSql('DROP TABLE __temp__page');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__page AS SELECT id, slug, title, content, lang, created_at, updated_at, deleted_at FROM page');
        $this->addSql('DROP TABLE page');
        $this->addSql('CREATE TABLE page (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, slug VARCHAR(50) NOT NULL, title VARCHAR(50) NOT NULL, content VARCHAR(3000) NOT NULL, lang VARCHAR(2) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO page (id, slug, title, content, lang, created_at, updated_at, deleted_at) SELECT id, slug, title, content, lang, created_at, updated_at, deleted_at FROM __temp__page');
        $this->addSql('DROP TABLE __temp__page');
    }
}
