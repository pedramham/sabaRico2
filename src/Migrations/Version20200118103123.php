<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200118103123 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(200) NOT NULL, title VARCHAR(255) NOT NULL, subject LONGTEXT NOT NULL, description LONGTEXT NOT NULL, description_seo LONGTEXT NOT NULL, small_pic VARCHAR(255) NOT NULL, label_key_word VARCHAR(255) NOT NULL, display_status TINYINT(1) NOT NULL, date_insert DATETIME NOT NULL, url_slug VARCHAR(255) NOT NULL, last_update DATETIME NOT NULL, price INT DEFAULT NULL, discount INT DEFAULT NULL, manufacturing_country VARCHAR(255) DEFAULT NULL, brand VARCHAR(255) DEFAULT NULL, guarantee VARCHAR(255) DEFAULT NULL, idCategoryProduct INT DEFAULT NULL, INDEX IDX_D34A04AD83F6CEDE (idCategoryProduct), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD83F6CEDE FOREIGN KEY (idCategoryProduct) REFERENCES category_product (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE product');
    }
}
