<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240426145243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payement (id INT AUTO_INCREMENT NOT NULL, second_key VARCHAR(20) DEFAULT NULL, is_paid TINYINT(1) NOT NULL, user_id INT NOT NULL, orders_details_id INT NOT NULL, INDEX IDX_B20A7885A76ED395 (user_id), INDEX IDX_B20A7885DED81EA5 (orders_details_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE payement ADD CONSTRAINT FK_B20A7885A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE payement ADD CONSTRAINT FK_B20A7885DED81EA5 FOREIGN KEY (orders_details_id) REFERENCES orders_details (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payement DROP FOREIGN KEY FK_B20A7885A76ED395');
        $this->addSql('ALTER TABLE payement DROP FOREIGN KEY FK_B20A7885DED81EA5');
        $this->addSql('DROP TABLE payement');
    }
}
