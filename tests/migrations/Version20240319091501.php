<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319091501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country DROP FOREIGN KEY FK_5373C966BE553C85');
        $this->addSql('DROP INDEX IDX_5373C966BE553C85 ON country');
        $this->addSql('ALTER TABLE country DROP country_order_id');
        $this->addSql('ALTER TABLE `order` ADD country_id INT DEFAULT NULL, ADD payement_method_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398396979B3 FOREIGN KEY (payement_method_id) REFERENCES method_payement (id)');
        $this->addSql('CREATE INDEX IDX_F5299398F92F3E70 ON `order` (country_id)');
        $this->addSql('CREATE INDEX IDX_F5299398396979B3 ON `order` (payement_method_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country ADD country_order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C966BE553C85 FOREIGN KEY (country_order_id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5373C966BE553C85 ON country (country_order_id)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398F92F3E70');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398396979B3');
        $this->addSql('DROP INDEX IDX_F5299398F92F3E70 ON `order`');
        $this->addSql('DROP INDEX IDX_F5299398396979B3 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP country_id, DROP payement_method_id');
    }
}
