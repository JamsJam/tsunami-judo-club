<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240805180851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_participationtype (event_id INT NOT NULL, participationtype_id INT NOT NULL, INDEX IDX_F69E929C71F7E88B (event_id), INDEX IDX_F69E929C461AED35 (participationtype_id), PRIMARY KEY(event_id, participationtype_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, licence_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_AB55E24F26EF07C9 (licence_id), INDEX IDX_AB55E24F71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation_participationtype (participation_id INT NOT NULL, participationtype_id INT NOT NULL, INDEX IDX_54B3DB9D6ACE3B73 (participation_id), INDEX IDX_54B3DB9D461AED35 (participationtype_id), PRIMARY KEY(participation_id, participationtype_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_participationtype ADD CONSTRAINT FK_F69E929C71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_participationtype ADD CONSTRAINT FK_F69E929C461AED35 FOREIGN KEY (participationtype_id) REFERENCES participationtype (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F26EF07C9 FOREIGN KEY (licence_id) REFERENCES licence (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE participation_participationtype ADD CONSTRAINT FK_54B3DB9D6ACE3B73 FOREIGN KEY (participation_id) REFERENCES participation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participation_participationtype ADD CONSTRAINT FK_54B3DB9D461AED35 FOREIGN KEY (participationtype_id) REFERENCES participationtype (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_participationtype DROP FOREIGN KEY FK_F69E929C71F7E88B');
        $this->addSql('ALTER TABLE event_participationtype DROP FOREIGN KEY FK_F69E929C461AED35');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F26EF07C9');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F71F7E88B');
        $this->addSql('ALTER TABLE participation_participationtype DROP FOREIGN KEY FK_54B3DB9D6ACE3B73');
        $this->addSql('ALTER TABLE participation_participationtype DROP FOREIGN KEY FK_54B3DB9D461AED35');
        $this->addSql('DROP TABLE event_participationtype');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE participation_participationtype');
    }
}
