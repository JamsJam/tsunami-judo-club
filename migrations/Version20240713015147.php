<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240713014046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'populate base information ';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('INSERT INTO grade (ceinture, grade) VALUES  ("blanc", "9e kyu"),("blanc-jaune", "8e kyu"),("jaune", "7e kyu"),("jaune-orange", "6e kyu"),("orange", "5e kyu"),("orange-vert", "4e kyu"),("vert", "3e kyu"),("bleu", "2e kyu"),("maron", "1er kyu"),("noir", "2e dan"),("noir", "3e dan"),("noir", "4e dan"),("noir", "5e dan"),("noir", "6e dan"),("noir", "7e dan"),("noir", "8e dan"),("noir", "9e dan")');
        $this->addSql('INSERT INTO arbitrelvl (niveaux) VALUES ("club"),("departemental"),("regional"),("national"),("international")');
        $this->addSql('INSERT INTO commissairelvl (niveaux) VALUES ("club"),("departemental"),("regional"),("national"),("international")');
        $this->addSql('INSERT INTO groupe (nom) VALUES  ("arbitre"), ("commissaire"), ("competiteur"), ("kata"), ("pole")');
        $this->addSql('INSERT INTO type (nom) VALUES  ("soutient"), ("judoka")');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE FROM Grade WHERE ceinture = "blanc" AND grade = "9e kyu"');
        $this->addSql('DELETE FROM Grade WHERE ceinture = "blanc-jaune" AND grade = "8e kyu"');
        $this->addSql('DELETE FROM Grade WHERE ceinture = "jaune" AND grade = "7e kyu"');
        $this->addSql('DELETE FROM Grade WHERE ceinture = "jaune-orange" AND grade = "6e kyu"');
        $this->addSql('DELETE FROM Grade WHERE ceinture = "orange" AND grade = "5e kyu"');
        $this->addSql('DELETE FROM Grade WHERE ceinture = "orange-vert" AND grade = "4e kyu"');
        $this->addSql('DELETE FROM Grade WHERE ceinture = "vert" AND grade = "3e kyu"');
        $this->addSql('DELETE FROM Grade WHERE ceinture = "bleu" AND grade = "2e kyu"');
        $this->addSql('DELETE FROM Grade WHERE ceinture = "maron" AND grade = "1er kyu"');
        $this->addSql('DELETE FROM Grade WHERE ceinture = "noir" AND grade = "2e dan"');
        $this->addSql('DELETE FROM Grade WHERE ceinture = "noir" AND grade = "3e dan"');
        $this->addSql('DELETE FROM Grade WHERE ceinture = "noir" AND grade = "4e dan"');
        $this->addSql('DELETE FROM Grade WHERE ceinture = "noir" AND grade = "5e dan"');
        $this->addSql('DELETE FROM Grade WHERE ceinture = "noir" AND grade = "6e dan"');
        $this->addSql('DELETE FROM Grade WHERE ceinture = "noir" AND grade = "7e dan"');
        $this->addSql('DELETE FROM Grade WHERE ceinture = "noir" AND grade = "8e dan"');
        $this->addSql('DELETE FROM Grade WHERE ceinture = "noir" AND grade = "9e dan"');

        $this->addSql('DELETE FROM Arbitrelvl WHERE niveaux = "club"');
        $this->addSql('DELETE FROM Arbitrelvl WHERE niveaux = "departemental"');
        $this->addSql('DELETE FROM Arbitrelvl WHERE niveaux = "regional"');
        $this->addSql('DELETE FROM Arbitrelvl WHERE niveaux = "national"');
        $this->addSql('DELETE FROM Arbitrelvl WHERE niveaux = "international"');

        $this->addSql('DELETE FROM Commissairelvl WHERE niveaux = "club"');
        $this->addSql('DELETE FROM Commissairelvl WHERE niveaux = "departemental"');
        $this->addSql('DELETE FROM Commissairelvl WHERE niveaux = "regional"');
        $this->addSql('DELETE FROM Commissairelvl WHERE niveaux = "national"');
        $this->addSql('DELETE FROM Commissairelvl WHERE niveaux = "international"');

        $this->addSql('DELETE FROM groupe WHERE nom IN ("arbitre", "commissaire", "competiteur", "kata", "pole")');
        $this->addSql('DELETE FROM type WHERE nom IN ("soutient", "judoka")');
    }
}
