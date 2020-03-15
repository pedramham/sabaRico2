<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200123114353 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE image_gallery_news');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE image_gallery_news (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, title VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, alt VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, file VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, displayStatus TINYINT(1) NOT NULL, dateInsert DATETIME DEFAULT NULL, subject LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, idNews INT DEFAULT NULL, INDEX IDX_8403C9B06E2EC7CE (idNews), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE image_gallery_news ADD CONSTRAINT FK_8403C9B06E2EC7CE FOREIGN KEY (idNews) REFERENCES news (id)');
    }
}
