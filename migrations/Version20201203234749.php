<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201203234749 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pointages ADD utilisateurs_id INT NOT NULL');
        $this->addSql('ALTER TABLE pointages ADD CONSTRAINT FK_2067B6D81E969C5 FOREIGN KEY (utilisateurs_id) REFERENCES utilisateurs (id)');
        $this->addSql('CREATE INDEX IDX_2067B6D81E969C5 ON pointages (utilisateurs_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pointages DROP FOREIGN KEY FK_2067B6D81E969C5');
        $this->addSql('DROP INDEX IDX_2067B6D81E969C5 ON pointages');
        $this->addSql('ALTER TABLE pointages DROP utilisateurs_id');
    }
}
