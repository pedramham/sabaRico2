<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200123105616 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image_gallery ADD idProduct INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image_gallery ADD CONSTRAINT FK_D23B2FE6C3F36F5F FOREIGN KEY (idProduct) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_D23B2FE6C3F36F5F ON image_gallery (idProduct)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image_gallery DROP FOREIGN KEY FK_D23B2FE6C3F36F5F');
        $this->addSql('DROP INDEX IDX_D23B2FE6C3F36F5F ON image_gallery');
        $this->addSql('ALTER TABLE image_gallery DROP idProduct');
    }
}
