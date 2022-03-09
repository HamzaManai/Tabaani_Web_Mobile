<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309110657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, code_id INT NOT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, createat DATETIME NOT NULL, jaime INT NOT NULL, detester INT NOT NULL, nbvue INT NOT NULL, INDEX IDX_C015514327DAFE17 (code_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, blog_id INT NOT NULL, comment VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, date_comment DATETIME NOT NULL, INDEX IDX_67F068BCDAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE influenceur (id INT AUTO_INCREMENT NOT NULL, code INT NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, nbr_followrs DOUBLE PRECISION DEFAULT NULL, instagram_page VARCHAR(255) DEFAULT NULL, facebook_page VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C015514327DAFE17 FOREIGN KEY (code_id) REFERENCES influenceur (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCDAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCDAE07E97');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C015514327DAFE17');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE influenceur');
    }
}
