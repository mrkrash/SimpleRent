<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230726180601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE affiliate (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, web VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD transaction_id INT DEFAULT NULL, ADD rate INT NOT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE2FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transations (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDE2FC0CB0F ON booking (transaction_id)');
        $this->addSql('ALTER TABLE cart ADD rate INT NOT NULL');
        $this->addSql('ALTER TABLE customer ADD newsletter TINYINT(1) NOT NULL, ADD privacy TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE product ADD bicycle_type VARCHAR(16) DEFAULT NULL');
        $this->addSql('ALTER TABLE transations ADD request_id VARCHAR(36) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE affiliate');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE2FC0CB0F');
        $this->addSql('DROP INDEX UNIQ_E00CEDDE2FC0CB0F ON booking');
        $this->addSql('ALTER TABLE booking DROP transaction_id, DROP rate');
        $this->addSql('ALTER TABLE cart DROP rate');
        $this->addSql('ALTER TABLE customer DROP newsletter, DROP privacy');
        $this->addSql('ALTER TABLE product DROP bicycle_type');
        $this->addSql('ALTER TABLE transations DROP request_id');
    }
}