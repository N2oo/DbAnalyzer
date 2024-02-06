<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206113248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depend_on DROP b_table');
        $this->addSql('ALTER TABLE depend_on DROP d_table');
        $this->addSql('ALTER TABLE depend_on ADD CONSTRAINT FK_7615DFD912AEC5A9 FOREIGN KEY (b_table_id) REFERENCES "table" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE depend_on ADD CONSTRAINT FK_7615DFD91FB0B5EE FOREIGN KEY (d_table_id) REFERENCES "table" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7615DFD912AEC5A9 ON depend_on (b_table_id)');
        $this->addSql('CREATE INDEX IDX_7615DFD91FB0B5EE ON depend_on (d_table_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE depend_on DROP CONSTRAINT FK_7615DFD912AEC5A9');
        $this->addSql('ALTER TABLE depend_on DROP CONSTRAINT FK_7615DFD91FB0B5EE');
        $this->addSql('DROP INDEX IDX_7615DFD912AEC5A9');
        $this->addSql('DROP INDEX IDX_7615DFD91FB0B5EE');
        $this->addSql('ALTER TABLE depend_on ADD b_table VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE depend_on ADD d_table VARCHAR(255) DEFAULT NULL');
    }
}
