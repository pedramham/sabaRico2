<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200125142652 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE PositionDisplay (id INT AUTO_INCREMENT NOT NULL, panelMostViewNews TINYINT(1) DEFAULT NULL, ppanelMostViewNews INT DEFAULT NULL, idNews INT DEFAULT NULL, INDEX IDX_4A74FCAF6E2EC7CE (idNews), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE PositionDisplay ADD CONSTRAINT FK_4A74FCAF6E2EC7CE FOREIGN KEY (idNews) REFERENCES news (id)');
        $this->addSql('DROP TABLE PositionDispalyNews');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE PositionDispalyNews (id INT AUTO_INCREMENT NOT NULL, panelMostViewNews TINYINT(1) DEFAULT NULL, ppanelMostViewNews INT DEFAULT NULL, idNews INT DEFAULT NULL, INDEX IDX_1424D3EB6E2EC7CE (idNews), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE PositionDispalyNews ADD CONSTRAINT FK_1424D3EB6E2EC7CE FOREIGN KEY (idNews) REFERENCES news (id)');
        $this->addSql('DROP TABLE PositionDisplay');
    }
}
