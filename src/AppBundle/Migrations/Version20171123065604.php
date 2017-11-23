<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171123065604 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, categoryId INT DEFAULT NULL, INDEX IDX_64C19C19C370B71 (categoryId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, text TEXT NOT NULL, newsId INT NOT NULL, INDEX IDX_9474526C19D52895 (newsId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, isActive TINYINT(1) NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, summary TEXT NOT NULL, text TEXT NOT NULL, categoryId INT NOT NULL, INDEX IDX_1DD399509C370B71 (categoryId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C19C370B71 FOREIGN KEY (categoryId) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C19D52895 FOREIGN KEY (newsId) REFERENCES news (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD399509C370B71 FOREIGN KEY (categoryId) REFERENCES category (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C19C370B71');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD399509C370B71');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C19D52895');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE news');
    }
}
