<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200118155642 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE images_gallery (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_images_gallery (article_id INT NOT NULL, images_gallery_id INT NOT NULL, INDEX IDX_7E6DEAD07294869C (article_id), INDEX IDX_7E6DEAD0B5418200 (images_gallery_id), PRIMARY KEY(article_id, images_gallery_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_images_gallery ADD CONSTRAINT FK_7E6DEAD07294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_images_gallery ADD CONSTRAINT FK_7E6DEAD0B5418200 FOREIGN KEY (images_gallery_id) REFERENCES images_gallery (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article_images_gallery DROP FOREIGN KEY FK_7E6DEAD0B5418200');
        $this->addSql('DROP TABLE images_gallery');
        $this->addSql('DROP TABLE article_images_gallery');
    }
}
