<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230309205655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add team to player entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player ADD team_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN player.team_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_98197A65296CD8AE ON player (team_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player DROP CONSTRAINT FK_98197A65296CD8AE');
        $this->addSql('DROP INDEX IDX_98197A65296CD8AE');
        $this->addSql('ALTER TABLE player DROP team_id');
    }
}
