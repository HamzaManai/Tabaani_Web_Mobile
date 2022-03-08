<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220303002121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, flying_from VARCHAR(255) NOT NULL, flying_to VARCHAR(255) NOT NULL, departing DATE NOT NULL, retour DATE NOT NULL, adults VARCHAR(255) NOT NULL, children VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, travel_class VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_voyage (reservation_id INT NOT NULL, voyage_id INT NOT NULL, INDEX IDX_776CC0CEB83297E7 (reservation_id), INDEX IDX_776CC0CE68C9E5AF (voyage_id), PRIMARY KEY(reservation_id, voyage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_voyage ADD CONSTRAINT FK_776CC0CEB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_voyage ADD CONSTRAINT FK_776CC0CE68C9E5AF FOREIGN KEY (voyage_id) REFERENCES voyage (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_voyage DROP FOREIGN KEY FK_776CC0CEB83297E7');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_voyage');
        $this->addSql('ALTER TABLE voyage CHANGE nom_voyage nom_voyage VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ville_depart ville_depart VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ville_destination ville_destination VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE numero_voyage numero_voyage VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom_agence nom_agence VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
