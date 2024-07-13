<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240713022651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adherent ADD licence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE adherent ADD CONSTRAINT FK_90D3F06026EF07C9 FOREIGN KEY (licence_id) REFERENCES licence (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_90D3F06026EF07C9 ON adherent (licence_id)');
        $this->addSql('ALTER TABLE licence DROP FOREIGN KEY FK_1DAAE64825F06C53');
        $this->addSql('DROP INDEX UNIQ_1DAAE64825F06C53 ON licence');
        $this->addSql('ALTER TABLE licence DROP adherent_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adherent DROP FOREIGN KEY FK_90D3F06026EF07C9');
        $this->addSql('DROP INDEX UNIQ_90D3F06026EF07C9 ON adherent');
        $this->addSql('ALTER TABLE adherent DROP licence_id');
        $this->addSql('ALTER TABLE licence ADD adherent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE licence ADD CONSTRAINT FK_1DAAE64825F06C53 FOREIGN KEY (adherent_id) REFERENCES adherent (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1DAAE64825F06C53 ON licence (adherent_id)');
    }
}
