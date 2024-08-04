<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240712235035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adherent CHANGE indicatif_pays indicatif_pays VARCHAR(4) DEFAULT NULL');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_licence (groupe_id INT NOT NULL, licence_id INT NOT NULL, INDEX IDX_DBCD01067A45358C (groupe_id), INDEX IDX_DBCD010626EF07C9 (licence_id), PRIMARY KEY(groupe_id, licence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE groupe_licence ADD CONSTRAINT FK_DBCD01067A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_licence ADD CONSTRAINT FK_DBCD010626EF07C9 FOREIGN KEY (licence_id) REFERENCES licence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE licence ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE licence ADD CONSTRAINT FK_1DAAE648C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_1DAAE648C54C8C93 ON licence (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        
        $this->addSql('ALTER TABLE adherent CHANGE indicatif_pays indicatif_pays VARCHAR(4) NOT NULL');
        $this->addSql('ALTER TABLE licence DROP FOREIGN KEY FK_1DAAE648C54C8C93');
        $this->addSql('ALTER TABLE groupe_licence DROP FOREIGN KEY FK_DBCD01067A45358C');
        $this->addSql('ALTER TABLE groupe_licence DROP FOREIGN KEY FK_DBCD010626EF07C9');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE groupe_licence');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP INDEX IDX_1DAAE648C54C8C93 ON licence');
        $this->addSql('ALTER TABLE licence DROP type_id');
    }
}
