<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200125140846 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE PositionDispalyNews DROP panelHotNewsTitre, DROP ppanelHotNewsTitre, DROP panelDetailsNews, DROP ppanelDetailsNews, DROP mainCatNewsDetails, DROP pmainCatNewsDetails');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE PositionDispalyNews ADD panelHotNewsTitre TINYINT(1) DEFAULT NULL, ADD ppanelHotNewsTitre INT DEFAULT NULL, ADD panelDetailsNews TINYINT(1) DEFAULT NULL, ADD ppanelDetailsNews INT DEFAULT NULL, ADD mainCatNewsDetails TINYINT(1) DEFAULT NULL, ADD pmainCatNewsDetails INT DEFAULT NULL');
    }
}
