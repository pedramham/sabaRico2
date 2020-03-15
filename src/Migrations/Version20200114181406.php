<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200114181406 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, family VARCHAR(60) NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(64) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', address VARCHAR(255) NOT NULL, telephon VARCHAR(255) NOT NULL, mobile VARCHAR(255) NOT NULL, picUser VARCHAR(255) NOT NULL, subject LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_news (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, subject LONGTEXT NOT NULL, description LONGTEXT NOT NULL, descriptionSeo LONGTEXT NOT NULL, smallPic VARCHAR(255) NOT NULL, largPic VARCHAR(255) NOT NULL, displayStatus TINYINT(1) NOT NULL, dateInsert DATETIME NOT NULL, labelKeyWord LONGTEXT DEFAULT NULL, urlSlug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, subject LONGTEXT NOT NULL, description LONGTEXT NOT NULL, descriptionSeo LONGTEXT NOT NULL, smallPic VARCHAR(255) NOT NULL, largPic VARCHAR(255) NOT NULL, labelKeyWord LONGTEXT DEFAULT NULL, displayStatus TINYINT(1) NOT NULL, dateInsert DATETIME NOT NULL, counterView VARCHAR(255) NOT NULL, urlSlug VARCHAR(255) NOT NULL, idCategory INT DEFAULT NULL, INDEX IDX_1DD3995055EF339A (idCategory), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_video (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(199) NOT NULL, title VARCHAR(199) NOT NULL, subject LONGTEXT NOT NULL, description LONGTEXT NOT NULL, description_seo LONGTEXT NOT NULL, small_pic VARCHAR(199) NOT NULL, large_pic VARCHAR(255) NOT NULL, code_color_brand VARCHAR(199) NOT NULL, display_status TINYINT(1) NOT NULL, date_insert DATETIME NOT NULL, label_key_word LONGTEXT NOT NULL, url_slug VARCHAR(199) NOT NULL, author_name VARCHAR(199) NOT NULL, last_update DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE PositionDispalyNews (id INT AUTO_INCREMENT NOT NULL, panelHotNewsTitre TINYINT(1) DEFAULT NULL, ppanelHotNewsTitre INT DEFAULT NULL, panelMostViewNews TINYINT(1) DEFAULT NULL, ppanelMostViewNews INT DEFAULT NULL, panelDetailsNews TINYINT(1) DEFAULT NULL, ppanelDetailsNews INT DEFAULT NULL, mainCatNewsDetails TINYINT(1) DEFAULT NULL, pmainCatNewsDetails INT DEFAULT NULL, idNews INT DEFAULT NULL, INDEX IDX_1424D3EB6E2EC7CE (idNews), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(199) NOT NULL, title VARCHAR(199) NOT NULL, subject LONGTEXT NOT NULL, description LONGTEXT NOT NULL, description_seo LONGTEXT NOT NULL, small_pic VARCHAR(199) NOT NULL, video_link VARCHAR(199) NOT NULL, during_video VARCHAR(199) NOT NULL, label_key_word VARCHAR(199) NOT NULL, display_status TINYINT(1) NOT NULL, date_insert DATETIME NOT NULL, counter_view INT DEFAULT NULL, url_slug VARCHAR(199) NOT NULL, last_update DATETIME NOT NULL, author_name VARCHAR(199) NOT NULL, idCategory INT DEFAULT NULL, INDEX IDX_7CC7DA2C55EF339A (idCategory), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD3995055EF339A FOREIGN KEY (idCategory) REFERENCES category_news (id)');
        $this->addSql('ALTER TABLE PositionDispalyNews ADD CONSTRAINT FK_1424D3EB6E2EC7CE FOREIGN KEY (idNews) REFERENCES news (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C55EF339A FOREIGN KEY (idCategory) REFERENCES category_video (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD3995055EF339A');
        $this->addSql('ALTER TABLE PositionDispalyNews DROP FOREIGN KEY FK_1424D3EB6E2EC7CE');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C55EF339A');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE category_news');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE category_video');
        $this->addSql('DROP TABLE PositionDispalyNews');
        $this->addSql('DROP TABLE video');
    }
}
