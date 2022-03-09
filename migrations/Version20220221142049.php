<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221142049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom_utl VARCHAR(255) NOT NULL, prenom_utl VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hebergement ADD user_id INT DEFAULT NULL, CHANGE date_hbrg date_hbrg DATE NOT NULL');
        $this->addSql('ALTER TABLE hebergement ADD CONSTRAINT FK_4852DD9CA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_4852DD9CA76ED395 ON hebergement (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hebergement DROP FOREIGN KEY FK_4852DD9CA76ED395');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP INDEX IDX_4852DD9CA76ED395 ON hebergement');
        $this->addSql('ALTER TABLE hebergement DROP user_id, CHANGE nom_hbrg nom_hbrg VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE adresse_hbrg adresse_hbrg VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_hbrg date_hbrg DATE DEFAULT NULL, CHANGE img_hbrg img_hbrg VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE proprietaire CHANGE nom_prop nom_prop VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom_prop prenom_prop VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email_prop email_prop VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE img_prop img_prop VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE type_hebergement CHANGE nom_type_hbrg nom_type_hbrg VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
