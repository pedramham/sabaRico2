<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200117142145 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE content (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, subject LONGTEXT NOT NULL, descriptionSeo LONGTEXT NOT NULL, smallPic VARCHAR(255) NOT NULL, largePic VARCHAR(255) NOT NULL, labelKeyWord VARCHAR(255) NOT NULL, displayStatus TINYINT(1) NOT NULL, dateInsert DATETIME DEFAULT NULL, counterView INT NOT NULL, urlSlug VARCHAR(255) NOT NULL, authorName VARCHAR(255) NOT NULL, lastUpdate DATETIME NOT NULL, idCategory INT DEFAULT NULL, INDEX IDX_FEC530A955EF339A (idCategory), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A955EF339A FOREIGN KEY (idCategory) REFERENCES category_content (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE content');
    }
}
