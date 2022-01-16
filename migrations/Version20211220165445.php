<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211220165445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Productimg change url to alt';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE productimg ADD alt VARCHAR(255) DEFAULT NULL, DROP url');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE productimg ADD url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP alt');
    }
}
