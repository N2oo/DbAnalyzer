<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206112855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depend_on DROP CONSTRAINT fk_7615dfd91fb0b5ee');
        $this->addSql('DROP INDEX idx_7615dfd91fb0b5ee');
        $this->addSql('ALTER TABLE depend_on ADD d_table VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE depend_on DROP d_table');
        $this->addSql('ALTER TABLE depend_on ADD CONSTRAINT fk_7615dfd91fb0b5ee FOREIGN KEY (d_table_id) REFERENCES "table" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_7615dfd91fb0b5ee ON depend_on (d_table_id)');
    }
}
