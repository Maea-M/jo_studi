<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240426152819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders_details ADD payement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orders_details ADD CONSTRAINT FK_835379F1868C0609 FOREIGN KEY (payement_id) REFERENCES payement (id)');
        $this->addSql('CREATE INDEX IDX_835379F1868C0609 ON orders_details (payement_id)');
        $this->addSql('ALTER TABLE payement DROP FOREIGN KEY FK_B20A7885DED81EA5');
        $this->addSql('DROP INDEX IDX_B20A7885DED81EA5 ON payement');
        $this->addSql('ALTER TABLE payement DROP orders_details_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payement ADD orders_details_id INT NOT NULL');
        $this->addSql('ALTER TABLE payement ADD CONSTRAINT FK_B20A7885DED81EA5 FOREIGN KEY (orders_details_id) REFERENCES orders_details (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B20A7885DED81EA5 ON payement (orders_details_id)');
        $this->addSql('ALTER TABLE orders_details DROP FOREIGN KEY FK_835379F1868C0609');
        $this->addSql('DROP INDEX IDX_835379F1868C0609 ON orders_details');
        $this->addSql('ALTER TABLE orders_details DROP payement_id');
    }
}
