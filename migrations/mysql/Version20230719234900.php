<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230719234900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_qty (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, size_xs INT NOT NULL, size_s INT NOT NULL, size_m INT NOT NULL, size_l INT NOT NULL, size_xl INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_28D7FA004584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_qty ADD CONSTRAINT FK_28D7FA004584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product ADD type VARCHAR(7) NOT NULL, DROP qty, DROP size');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_qty DROP FOREIGN KEY FK_28D7FA004584665A');
        $this->addSql('DROP TABLE product_qty');
        $this->addSql('ALTER TABLE product ADD qty INT NOT NULL, ADD size VARCHAR(255) NOT NULL, DROP type');
    }
}