<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211222134102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'offres pro';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD offrepro TINYINT(1) DEFAULT \'0\' NOT NULL, ADD plans VARCHAR(255) NOT NULL, ADD dataroom VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP offrepro, DROP plans, DROP dataroom');
    }
}
