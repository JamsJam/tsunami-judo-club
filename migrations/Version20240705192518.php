<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240705192518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE licence DROP FOREIGN KEY FK_1DAAE648B181C9A7');
        $this->addSql('CREATE TABLE arbitrelvl (id INT AUTO_INCREMENT NOT NULL, niveaux VARCHAR(40) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE arbitre_grade');
        $this->addSql('DROP INDEX IDX_1DAAE648B181C9A7 ON licence');
        $this->addSql('ALTER TABLE licence CHANGE arbitre_grade_id arbitrelvl_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE licence ADD CONSTRAINT FK_1DAAE6484ACAB3D0 FOREIGN KEY (arbitrelvl_id) REFERENCES arbitrelvl (id)');
        $this->addSql('CREATE INDEX IDX_1DAAE6484ACAB3D0 ON licence (arbitrelvl_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE licence DROP FOREIGN KEY FK_1DAAE6484ACAB3D0');
        $this->addSql('CREATE TABLE arbitre_grade (id INT AUTO_INCREMENT NOT NULL, niveaux VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE arbitrelvl');
        $this->addSql('DROP INDEX IDX_1DAAE6484ACAB3D0 ON licence');
        $this->addSql('ALTER TABLE licence CHANGE arbitrelvl_id arbitre_grade_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE licence ADD CONSTRAINT FK_1DAAE648B181C9A7 FOREIGN KEY (arbitre_grade_id) REFERENCES arbitre_grade (id)');
        $this->addSql('CREATE INDEX IDX_1DAAE648B181C9A7 ON licence (arbitre_grade_id)');
    }
}
