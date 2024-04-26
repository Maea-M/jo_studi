<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240426144308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payement DROP FOREIGN KEY FK_B20A7885A76ED395');
        $this->addSql('ALTER TABLE payement DROP FOREIGN KEY FK_B20A7885DED81EA5');
        $this->addSql('DROP TABLE payement');
        $this->addSql('ALTER TABLE orders_details CHANGE is_paid is_paid TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payement (id INT AUTO_INCREMENT NOT NULL, second_key VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, is_paid TINYINT(1) DEFAULT NULL, user_id INT DEFAULT NULL, orders_details_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_B20A7885DED81EA5 (orders_details_id), UNIQUE INDEX UNIQ_B20A78857369DBBA (second_key), INDEX IDX_B20A7885A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE payement ADD CONSTRAINT FK_B20A7885A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE payement ADD CONSTRAINT FK_B20A7885DED81EA5 FOREIGN KEY (orders_details_id) REFERENCES orders_details (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE orders_details CHANGE is_paid is_paid TINYINT(1) DEFAULT NULL');
    }
}
