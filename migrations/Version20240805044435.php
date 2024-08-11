<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240805044435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', edited_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', begin_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, is_public TINYINT(1) NOT NULL, INDEX IDX_3BAE0AA7C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_licence (event_id INT NOT NULL, licence_id INT NOT NULL, INDEX IDX_98FD4FE771F7E88B (event_id), INDEX IDX_98FD4FE726EF07C9 (licence_id), PRIMARY KEY(event_id, licence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eventstype (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participationtype (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7C54C8C93 FOREIGN KEY (type_id) REFERENCES eventstype (id)');
        $this->addSql('ALTER TABLE event_licence ADD CONSTRAINT FK_98FD4FE771F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_licence ADD CONSTRAINT FK_98FD4FE726EF07C9 FOREIGN KEY (licence_id) REFERENCES licence (id) ON DELETE CASCADE');
        $this->addSql('INSERT INTO eventstype (nom) VALUES ("competition"), ("anniversaire"), ("commande"), ("rassemblement"), ("stage"), ("reunion")');
        $this->addSql('INSERT INTO participationtype (nom) VALUES ("competiteur"), ("participant"), ("arbitre"), ("commissaire"), ("accompagnant"), ("staff"),("organisateur")');
        
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE FROM participationtype WHERE nom IN ("competiteur", "participant", "arbitre", "commissaire", "accompagnant", "staff","organisateur")');
        $this->addSql('DELETE FROM eventstype WHERE nom IN ("competition", "anniversaire", "commande", "rassemblement", "stage", "reunion")');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7C54C8C93');
        $this->addSql('ALTER TABLE event_licence DROP FOREIGN KEY FK_98FD4FE771F7E88B');
        $this->addSql('ALTER TABLE event_licence DROP FOREIGN KEY FK_98FD4FE726EF07C9');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_licence');
        $this->addSql('DROP TABLE eventstype');
        $this->addSql('DROP TABLE participationtype');
    }
}
