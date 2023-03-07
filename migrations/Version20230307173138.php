<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307173138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE field ADD use_property_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE field ADD CONSTRAINT FK_5BF545581620FF6E FOREIGN KEY (use_property_id) REFERENCES field (id)');
        $this->addSql('CREATE INDEX IDX_5BF545581620FF6E ON field (use_property_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE field DROP FOREIGN KEY FK_5BF545581620FF6E');
        $this->addSql('DROP INDEX IDX_5BF545581620FF6E ON field');
        $this->addSql('ALTER TABLE field DROP use_property_id');
    }
}
