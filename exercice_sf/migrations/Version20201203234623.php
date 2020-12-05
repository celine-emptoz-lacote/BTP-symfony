<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201203234623 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pointages ADD chantiers_id INT NOT NULL');
        $this->addSql('ALTER TABLE pointages ADD CONSTRAINT FK_2067B6D8691F92D8 FOREIGN KEY (chantiers_id) REFERENCES chantiers (id)');
        $this->addSql('CREATE INDEX IDX_2067B6D8691F92D8 ON pointages (chantiers_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pointages DROP FOREIGN KEY FK_2067B6D8691F92D8');
        $this->addSql('DROP INDEX IDX_2067B6D8691F92D8 ON pointages');
        $this->addSql('ALTER TABLE pointages DROP chantiers_id');
    }
}
