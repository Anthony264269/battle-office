<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319095518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shipping DROP FOREIGN KEY FK_2D1C172411702397');
        $this->addSql('DROP INDEX IDX_2D1C172411702397 ON shipping');
        $this->addSql('ALTER TABLE shipping DROP shipping_order_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shipping ADD shipping_order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shipping ADD CONSTRAINT FK_2D1C172411702397 FOREIGN KEY (shipping_order_id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_2D1C172411702397 ON shipping (shipping_order_id)');
    }
}
