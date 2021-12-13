<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211213144023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE productimg ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE productimg ADD CONSTRAINT FK_98076BC64584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_98076BC64584665A ON productimg (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE productimg DROP FOREIGN KEY FK_98076BC64584665A');
        $this->addSql('DROP INDEX IDX_98076BC64584665A ON productimg');
        $this->addSql('ALTER TABLE productimg DROP product_id');
    }
}
