<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240704233943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE certificates (id INT AUTO_INCREMENT NOT NULL, licences_id INT DEFAULT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', expire_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', path VARCHAR(255) NOT NULL, INDEX IDX_8D26FB5F5EF2836 (licences_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE certificates ADD CONSTRAINT FK_8D26FB5F5EF2836 FOREIGN KEY (licences_id) REFERENCES licence (id)');
        $this->addSql('ALTER TABLE licence CHANGE uograded_at upgraded_at DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certificates DROP FOREIGN KEY FK_8D26FB5F5EF2836');
        $this->addSql('DROP TABLE certificates');
        $this->addSql('ALTER TABLE licence CHANGE upgraded_at uograded_at DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\'');
    }
}
