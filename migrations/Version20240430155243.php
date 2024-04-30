<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240430155243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE qrcode (id INT AUTO_INCREMENT NOT NULL, secret_key VARCHAR(255) NOT NULL, user_id INT DEFAULT NULL, payement_id INT DEFAULT NULL, orders_details_id INT DEFAULT NULL, INDEX IDX_A4FF23ECA76ED395 (user_id), INDEX IDX_A4FF23EC868C0609 (payement_id), INDEX IDX_A4FF23ECDED81EA5 (orders_details_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE qrcode ADD CONSTRAINT FK_A4FF23ECA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE qrcode ADD CONSTRAINT FK_A4FF23EC868C0609 FOREIGN KEY (payement_id) REFERENCES payement (id)');
        $this->addSql('ALTER TABLE qrcode ADD CONSTRAINT FK_A4FF23ECDED81EA5 FOREIGN KEY (orders_details_id) REFERENCES orders_details (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qrcode DROP FOREIGN KEY FK_A4FF23ECA76ED395');
        $this->addSql('ALTER TABLE qrcode DROP FOREIGN KEY FK_A4FF23EC868C0609');
        $this->addSql('ALTER TABLE qrcode DROP FOREIGN KEY FK_A4FF23ECDED81EA5');
        $this->addSql('DROP TABLE qrcode');
    }
}
