<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230902220248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Recreate Page Table for news';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE slide');
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(8) NOT NULL, slug VARCHAR(50) NOT NULL, title VARCHAR(50) NOT NULL, date DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , content CLOB NOT NULL, lang VARCHAR(2) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , deleted_at VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE slide (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, page_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_72EFEE62C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_72EFEE62C4663E4 ON slide (page_id)');
    }

    public function down(Schema $schema): void
    {
    }
}
