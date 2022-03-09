<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220223173008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_69E399D63058E56F ON proprietaire (email_prop)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_69E399D632F991FF ON proprietaire (num_tlf_prop)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34B0A0D19A44478 ON type_hebergement (nom_type_hbrg)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hebergement CHANGE nom_hbrg nom_hbrg VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE adresse_hbrg adresse_hbrg VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE img_hbrg img_hbrg VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX UNIQ_69E399D63058E56F ON proprietaire');
        $this->addSql('DROP INDEX UNIQ_69E399D632F991FF ON proprietaire');
        $this->addSql('ALTER TABLE proprietaire CHANGE nom_prop nom_prop VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom_prop prenom_prop VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email_prop email_prop VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE img_prop img_prop VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX UNIQ_34B0A0D19A44478 ON type_hebergement');
        $this->addSql('ALTER TABLE type_hebergement CHANGE nom_type_hbrg nom_type_hbrg VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE utilisateur CHANGE nom_utl nom_utl VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom_utl prenom_utl VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
