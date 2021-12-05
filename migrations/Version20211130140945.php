<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211130140945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD annonces VARCHAR(255) NOT NULL, ADD etat VARCHAR(255) NOT NULL, ADD dispo_date VARCHAR(255) NOT NULL, ADD montant_taxe_fonciere DOUBLE PRECISION NOT NULL, ADD montant_charges DOUBLE PRECISION NOT NULL, ADD montant_taxe_bureaux DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP annonces, DROP etat, DROP dispo_date, DROP montant_taxe_fonciere, DROP montant_charges, DROP montant_taxe_bureaux');
    }
}
