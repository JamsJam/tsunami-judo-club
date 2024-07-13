<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240705200735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commissairelvl (id INT AUTO_INCREMENT NOT NULL, niveaux VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contacturgence (id INT AUTO_INCREMENT NOT NULL, licence_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1ADCBBCF26EF07C9 (licence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contacturgence ADD CONSTRAINT FK_1ADCBBCF26EF07C9 FOREIGN KEY (licence_id) REFERENCES licence (id)');
        $this->addSql('ALTER TABLE licence ADD commissairelvl_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE licence ADD CONSTRAINT FK_1DAAE6487E144B9E FOREIGN KEY (commissairelvl_id) REFERENCES commissairelvl (id)');
        $this->addSql('CREATE INDEX IDX_1DAAE6487E144B9E ON licence (commissairelvl_id)');
        
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE licence DROP FOREIGN KEY FK_1DAAE6487E144B9E');
        $this->addSql('ALTER TABLE contacturgence DROP FOREIGN KEY FK_1ADCBBCF26EF07C9');
        $this->addSql('DROP TABLE commissairelvl');
        $this->addSql('DROP TABLE contacturgence');
        $this->addSql('DROP INDEX IDX_1DAAE6487E144B9E ON licence');
        $this->addSql('ALTER TABLE licence DROP commissairelvl_id');
    }
}
