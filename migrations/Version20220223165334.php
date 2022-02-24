<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220223165334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voyage CHANGE nom_voyage nom_voyage VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ville_depart ville_depart VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ville_destination ville_destination VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE numero_voyage numero_voyage VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom_agence nom_agence VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
