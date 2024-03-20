<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319092710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP product');
        $this->addSql('ALTER TABLE product ADD product_order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD462F07AF FOREIGN KEY (product_order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD462F07AF ON product (product_order_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD product VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD462F07AF');
        $this->addSql('DROP INDEX IDX_D34A04AD462F07AF ON product');
        $this->addSql('ALTER TABLE product DROP product_order_id');
    }
}
