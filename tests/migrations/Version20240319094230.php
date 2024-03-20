<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319094230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE method_payement DROP FOREIGN KEY FK_546D361755223ADE');
        $this->addSql('DROP INDEX IDX_546D361755223ADE ON method_payement');
        $this->addSql('ALTER TABLE method_payement DROP method_payement_order_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398396979B3');
        $this->addSql('DROP INDEX IDX_F5299398396979B3 ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE payement_method_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_F52993984584665A ON `order` (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984584665A');
        $this->addSql('DROP INDEX IDX_F52993984584665A ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE product_id payement_method_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398396979B3 FOREIGN KEY (payement_method_id) REFERENCES method_payement (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F5299398396979B3 ON `order` (payement_method_id)');
        $this->addSql('ALTER TABLE method_payement ADD method_payement_order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE method_payement ADD CONSTRAINT FK_546D361755223ADE FOREIGN KEY (method_payement_order_id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_546D361755223ADE ON method_payement (method_payement_order_id)');
    }
}
