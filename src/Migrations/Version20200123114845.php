<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200123114845 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE image_gallery_service');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE image_gallery_service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, title VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, alt VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, file VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, displayStatus TINYINT(1) NOT NULL, dateInsert DATETIME DEFAULT NULL, subject LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, idService INT DEFAULT NULL, INDEX IDX_7417C56BF124F120 (idService), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE image_gallery_service ADD CONSTRAINT FK_7417C56BF124F120 FOREIGN KEY (idService) REFERENCES service (id)');
    }
}
