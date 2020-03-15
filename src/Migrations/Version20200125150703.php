<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200125150703 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE PositionDisplay ADD idArticle INT DEFAULT NULL');
        $this->addSql('ALTER TABLE PositionDisplay ADD CONSTRAINT FK_4A74FCAF12836594 FOREIGN KEY (idArticle) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_4A74FCAF12836594 ON PositionDisplay (idArticle)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE PositionDisplay DROP FOREIGN KEY FK_4A74FCAF12836594');
        $this->addSql('DROP INDEX IDX_4A74FCAF12836594 ON PositionDisplay');
        $this->addSql('ALTER TABLE PositionDisplay DROP idArticle');
    }
}
