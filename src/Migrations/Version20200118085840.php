<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200118085840 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category_product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, subject LONGTEXT NOT NULL, description LONGTEXT NOT NULL, description_seo LONGTEXT NOT NULL, small_pic VARCHAR(255) NOT NULL, large_pic VARCHAR(255) DEFAULT NULL, display_status TINYINT(1) NOT NULL, date_insert DATETIME NOT NULL, label_key_word VARCHAR(255) NOT NULL, url_slug VARCHAR(255) NOT NULL, idCategoryGeneralProduct INT DEFAULT NULL, INDEX IDX_149244D37253A25 (idCategoryGeneralProduct), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_product ADD CONSTRAINT FK_149244D37253A25 FOREIGN KEY (idCategoryGeneralProduct) REFERENCES category_general_product (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE category_product');
    }
}
