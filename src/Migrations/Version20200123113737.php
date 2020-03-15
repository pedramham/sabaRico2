<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200123113737 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image_gallery ADD idNews INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image_gallery ADD CONSTRAINT FK_D23B2FE66E2EC7CE FOREIGN KEY (idNews) REFERENCES news (id)');
        $this->addSql('CREATE INDEX IDX_D23B2FE66E2EC7CE ON image_gallery (idNews)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image_gallery DROP FOREIGN KEY FK_D23B2FE66E2EC7CE');
        $this->addSql('DROP INDEX IDX_D23B2FE66E2EC7CE ON image_gallery');
        $this->addSql('ALTER TABLE image_gallery DROP idNews');
    }
}
