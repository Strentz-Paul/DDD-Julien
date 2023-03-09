<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230309215753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add match game entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE match_game (id UUID NOT NULL, home_team_id UUID DEFAULT NULL, visitor_team_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_424480FE9C4C13F6 ON match_game (home_team_id)');
        $this->addSql('CREATE INDEX IDX_424480FEEB7F4866 ON match_game (visitor_team_id)');
        $this->addSql('COMMENT ON COLUMN match_game.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN match_game.home_team_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN match_game.visitor_team_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE match_game ADD CONSTRAINT FK_424480FE9C4C13F6 FOREIGN KEY (home_team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE match_game ADD CONSTRAINT FK_424480FEEB7F4866 FOREIGN KEY (visitor_team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE match_game DROP CONSTRAINT FK_424480FE9C4C13F6');
        $this->addSql('ALTER TABLE match_game DROP CONSTRAINT FK_424480FEEB7F4866');
        $this->addSql('DROP TABLE match_game');
    }
}
