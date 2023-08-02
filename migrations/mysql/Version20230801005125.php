<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230801005125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Association mapping Booking -> Product';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booked_product (id INT AUTO_INCREMENT NOT NULL, booking_id INT NOT NULL, product_id INT NOT NULL, qty INT NOT NULL, size VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_48D9FA083301C60 (booking_id), INDEX IDX_48D9FA084584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booked_product ADD CONSTRAINT FK_48D9FA083301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('ALTER TABLE booked_product ADD CONSTRAINT FK_48D9FA084584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE booking DROP products, DROP accessories');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booked_product DROP FOREIGN KEY FK_48D9FA083301C60');
        $this->addSql('ALTER TABLE booked_product DROP FOREIGN KEY FK_48D9FA084584665A');
        $this->addSql('DROP TABLE booked_product');
        $this->addSql('ALTER TABLE booking ADD products LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD accessories LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }
}
