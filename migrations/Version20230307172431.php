<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307172431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `database` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE field (id INT AUTO_INCREMENT NOT NULL, for_table_id INT NOT NULL, type_id INT NOT NULL, name VARCHAR(255) NOT NULL, length INT NOT NULL, INDEX IDX_5BF54558A91C414E (for_table_id), INDEX IDX_5BF54558C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE field_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `table` (id INT AUTO_INCREMENT NOT NULL, for_db_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_F6298F462209D790 (for_db_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE field ADD CONSTRAINT FK_5BF54558A91C414E FOREIGN KEY (for_table_id) REFERENCES `table` (id)');
        $this->addSql('ALTER TABLE field ADD CONSTRAINT FK_5BF54558C54C8C93 FOREIGN KEY (type_id) REFERENCES field_type (id)');
        $this->addSql('ALTER TABLE `table` ADD CONSTRAINT FK_F6298F462209D790 FOREIGN KEY (for_db_id) REFERENCES `database` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE field DROP FOREIGN KEY FK_5BF54558A91C414E');
        $this->addSql('ALTER TABLE field DROP FOREIGN KEY FK_5BF54558C54C8C93');
        $this->addSql('ALTER TABLE `table` DROP FOREIGN KEY FK_F6298F462209D790');
        $this->addSql('DROP TABLE `database`');
        $this->addSql('DROP TABLE field');
        $this->addSql('DROP TABLE field_type');
        $this->addSql('DROP TABLE `table`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
