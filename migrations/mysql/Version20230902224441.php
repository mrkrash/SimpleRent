<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230902224441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added News';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booked_product CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page ADD type VARCHAR(8) NOT NULL, ADD date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE product_qty DROP FOREIGN KEY FK_28D7FA004584665A');
        $this->addSql('ALTER TABLE product_qty ADD CONSTRAINT FK_28D7FA004584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booked_product CHANGE product_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE page DROP type, DROP date');
        $this->addSql('ALTER TABLE product_qty DROP FOREIGN KEY FK_28D7FA004584665A');
        $this->addSql('ALTER TABLE product_qty ADD CONSTRAINT FK_28D7FA004584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }
}
