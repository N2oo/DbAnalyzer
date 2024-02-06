<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206113804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depend_on ADD b_table_id_original INT NOT NULL');
        $this->addSql('ALTER TABLE depend_on ADD d_table_id_original INT NOT NULL');
        $this->addSql('ALTER TABLE depend_on ALTER b_table_id DROP NOT NULL');
        $this->addSql('ALTER TABLE depend_on ALTER d_table_id DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE depend_on DROP b_table_id_original');
        $this->addSql('ALTER TABLE depend_on DROP d_table_id_original');
        $this->addSql('ALTER TABLE depend_on ALTER b_table_id SET NOT NULL');
        $this->addSql('ALTER TABLE depend_on ALTER d_table_id SET NOT NULL');
    }
}
