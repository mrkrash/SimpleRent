<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230805135642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Slide to generic page';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE slide (id INT AUTO_INCREMENT NOT NULL, page_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_72EFEE62C4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE slide ADD CONSTRAINT FK_72EFEE62C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE slide DROP FOREIGN KEY FK_72EFEE62C4663E4');
        $this->addSql('DROP TABLE slide');
    }
}
