<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230722125311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDECAE8710B');
        $this->addSql('CREATE TABLE transations (id INT AUTO_INCREMENT NOT NULL, transport VARCHAR(6) NOT NULL, transport_id VARCHAR(32) NOT NULL, transport_status VARCHAR(40) NOT NULL, transport_details LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', amount INT NOT NULL, levied INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking_accessory DROP FOREIGN KEY FK_3283EE1F27E8CC78');
        $this->addSql('ALTER TABLE booking_accessory DROP FOREIGN KEY FK_3283EE1F3301C60');
        $this->addSql('ALTER TABLE booking_product DROP FOREIGN KEY FK_89F4418D4584665A');
        $this->addSql('ALTER TABLE booking_product DROP FOREIGN KEY FK_89F4418D3301C60');
        $this->addSql('DROP TABLE booking_accessory');
        $this->addSql('DROP TABLE booking_product');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP INDEX UNIQ_E00CEDDECAE8710B ON booking');
        $this->addSql('ALTER TABLE booking ADD products LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD accessories LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', DROP payment_transaction_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_accessory (booking_id INT NOT NULL, accessory_id INT NOT NULL, INDEX IDX_3283EE1F27E8CC78 (accessory_id), INDEX IDX_3283EE1F3301C60 (booking_id), PRIMARY KEY(booking_id, accessory_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE booking_product (booking_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_89F4418D3301C60 (booking_id), INDEX IDX_89F4418D4584665A (product_id), PRIMARY KEY(booking_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, serial VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, transport VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, amount INT NOT NULL, levied INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE booking_accessory ADD CONSTRAINT FK_3283EE1F27E8CC78 FOREIGN KEY (accessory_id) REFERENCES accessory (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_accessory ADD CONSTRAINT FK_3283EE1F3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_product ADD CONSTRAINT FK_89F4418D4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_product ADD CONSTRAINT FK_89F4418D3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE transations');
        $this->addSql('ALTER TABLE booking ADD payment_transaction_id INT NOT NULL, DROP products, DROP accessories');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDECAE8710B FOREIGN KEY (payment_transaction_id) REFERENCES transaction (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDECAE8710B ON booking (payment_transaction_id)');
    }
}